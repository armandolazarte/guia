<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Egreso;
use Guia\Models\RelInterna;
use Guia\Models\RelInternaDoc;
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
        $rel_interna = RelInterna::findOrFail($rel_interna_id);

        if ($rel_interna->tipo_documentos == 'Egresos') {
            /**
             * @todo Filtrar egresos que no estén en relaciones en tránsito
             * @todo Filtrar egresos por grupo de usuarios
             */

            $documentos = Egreso::whereUserId(\Auth::user()->id)->get();
            //$documentos = Egreso::all();//Only for testing

            $documentos->load('benef');
            $documentos->load('cuentaBancaria');
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
            $egreso = Egreso::find($doc_id);
            $egreso->user_id = \Auth::user()->id;
            $egreso->save();

            $egreso_rel_interna = $egreso->relacionInternaDocs()->where('rel_interna_id', $id)->first();
            $egreso_rel_interna->validacion = 'Aceptada';
            $egreso_rel_interna->save();
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
