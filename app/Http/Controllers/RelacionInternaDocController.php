<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Egreso;
use Guia\Models\RelInterna;
use Guia\Models\RelInternaDoc;
use Guia\Models\Solicitud;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class RelacionInternaDocController extends Controller
{
    /**
     * Lista los documentos para agregar a relación.
     *
     * @return Response
     */
    public function create($rel_interna_id)
    {
        $presupuesto = \Session::get('sel_presupuesto');

        $rel_interna = RelInterna::findOrFail($rel_interna_id);

        //Consulta los usuarios de los grupos "Colectivos" a los que se pertenece
        $grupos_usuarios = \Auth::user()->grupos()
            ->where('tipo', 'LIKE', '%Colectivo%')
            ->with(['users' => function($query){
                $query->wherePivot('supervisa', '!=', 1);
                $query->addSelect(['user_id']);
            }])->get();
        $grupos_usuarios = $grupos_usuarios->map(function ($grupo){
            return $grupo->users->pluck('user_id');
        });
        $arr_usuarios_grupo = [];
        foreach ($grupos_usuarios as $grupo) {
            foreach ($grupo as $user_id) {
                //Genera $arr_usuarios_grupo para filtrar documentos por user_id
                $arr_usuarios_grupo[] = $user_id;
            }
        }

        switch($rel_interna->tipo_documentos) {
            case 'Egresos':
                $modelo = 'Guia\Models\Egreso'; break;
            case 'Solicitudes':
                $modelo = 'Guia\Models\Solicitud'; break;
        }
        $documentos_en_transito = [];
        $documentos_en_transito = RelInternaDoc::distinct()->select('docable_id')
            ->whereDocableType($modelo)
            ->where('validacion','=','')
            ->groupBy('docable_id')
            ->lists('docable_id')->all();

        if($rel_interna->tipo_documentos == 'Egresos') {
            $documentos = Egreso::where('fecha', '>=', $presupuesto.'-01-01')
                ->whereNested(function($query) use ($arr_usuarios_grupo) {
                    $query->whereIn('user_id', $arr_usuarios_grupo);
                    $query->orWhere('user_id', '=', \Auth::user()->id);
                })
                ->whereNotIn('id', $documentos_en_transito)
                ->orderBy('cheque', 'desc')
                ->get();

            $documentos->load('benef');
            $documentos->load('cuentaBancaria');
        }

        if($rel_interna->tipo_documentos == 'Solicitudes') {
            $documentos = Solicitud::whereNested( function($query) use ($arr_usuarios_grupo) {
                    $query->whereIn('user_id', $arr_usuarios_grupo);
                    $query->orWhere('user_id', '=', \Auth::user()->id);
                })
                ->whereNotIn('id', $documentos_en_transito)
                ->orderBy('id')
                ->get();
            $documentos->load('benef');
            $documentos->load('proyecto');
        }

        $accion = 'agregar-docs';
        return view('relint.formRelInternaDoc', compact('rel_interna', 'documentos', 'accion'));
    }

    /**
     * Guarda el documento en la relación interna.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rel_interna_docs = RelInternaDoc::create([
            'rel_interna_id' => $request->input('rel_interna_id')
        ]);

        if ($request->input('doc_type') == 'Egreso') {
            $doc = Egreso::find($request->input('doc_id'));
            $ocultar_id = 'egreso-'.$request->input('doc_id');
            $message = "Egreso ".$request->input('doc_id').' agregado';
        }

        if ($request->input('doc_type') == 'Solicitud') {
            $doc = Solicitud::find($request->input('doc_id'));
            $ocultar_id = 'solicitud-'.$request->input('doc_id');
            $message = "Solicitud ".$request->input('doc_id').' agregada';
        }

        $doc->relacionInternaDocs()->save($rel_interna_docs);

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
                'ocultar' => $ocultar_id
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $rel_interna = RelInterna::findOrFail($id);
        $rel_interna->load('relInternaDocs');
        $documentos = [];
        foreach ($rel_interna->relInternaDocs as $doc) {
            $documentos[] = RelInternaDoc::find($doc->id)->docable;
        }

        $accion = 'recibir-docs';
        return view('relint.formRelInternaDoc', compact('rel_interna','documentos','accion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $rel_interna = RelInterna::findOrFail($id);
        $rel_interna->fecha_revision = Carbon::today()->toDateString();
        $rel_interna->recibe = \Auth::user()->id;
        $rel_interna->estatus = 'Recibida';
        $rel_interna->save();

        foreach ($request->input('docs') as $doc_id) {
            if($rel_interna->tipo_documentos == 'Egresos') {
                $documento = Egreso::find($doc_id);
            }

            if($rel_interna->tipo_documentos == 'Solicitudes') {
                $documento = Solicitud::find($doc_id);
            }

            $documento->user_id = \Auth::user()->id;
            $documento->save();

            $documento_rel_interna = $documento->relacionInternaDocs()->where('rel_interna_id', $id)->first();
            $documento_rel_interna->validacion = 'Aceptada';
            $documento_rel_interna->save();
        }

        $rel_interna->load('relInternaDocs');
        foreach ($rel_interna->relInternaDocs as $doc) {
            if (empty($doc->validacion)) {
                RelInternaDoc::find($doc->id)->update(['validacion' => 'Rechazada']);
            }
        }

        $message = 'Relación '.$rel_interna->id.' recibida con éxito';

        return redirect()->action('RelacionInternaController@index')
            ->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
