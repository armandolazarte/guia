<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Grupo;
use Guia\Models\RelInterna;
use Guia\User;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class RelacionInternaController extends Controller
{
    /**
     * Lista relaciones internas.
     *
     * @return Response
     */
    public function index()
    {
        $rel_enviadas = RelInterna::where('envia', \Auth::user()->id)->get();

        //Recibidas y por recibir
        $user = \Auth::user();
        $rel_destino_user = [];
        $rel_destino_grupo = [];
        $rel_destino_user =  $user->relInternas()->orderBy('estatus')->get();
        $rel_destino_grupo = $user->grupos()
            ->where('tipo', 'like', '%Colectivo%')
            ->with(['relInternas' => function($query){
                $query->orderBy('estatus','fecha_envio');
            }])->get();

        return view('relint.indexRelInterna', compact('rel_enviadas','rel_destino_user','rel_destino_grupo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rel_interna = RelInterna::create([
            'envia' => \Auth::user()->id,
            'estatus' => '',
            'tipo_documentos' => $request->input('tipo_documentos')
        ]);

        return redirect()->action('RelacionInternaDocController@create', $rel_interna->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $rel_interna = RelInterna::findOrFail($id);

        $grupos = Grupo::where('tipo', 'LIKE', 'Finanzas%')
            ->orWhere('tipo', 'LIKE', 'Suministros%')
            ->with(['users' => function($query){
                $query->addSelect(['users.id','nombre']);
                $query->where('users.id', '!=', \Auth::user()->id);
                $query->orderBy('nombre');
            }])
            ->get();

        $grupos_colectivo = $grupos->filter(function ($grupo) {
            return $grupo->tipo == 'Finanzas Colectivo';
        });
        $grupos_colectivo = $grupos_colectivo->pluck('grupo','id');
        $arr_grupos = $grupos_colectivo->toArray();

        $grupos_usuarios = $grupos->filter(function ($grupo) {
            return $grupo->tipo == 'Finanzas Individual';
        });
        $grupos_usuarios = $grupos_usuarios->pluck('users', 'grupo');
        $grupos_usuarios = $grupos_usuarios->map(function ($grupo){
            return $grupo->pluck('nombre', 'id');
        });
        $arr_usuarios = $grupos_usuarios->toArray();

        return view('relint.infoRelInterna', compact('rel_interna','arr_grupos','arr_usuarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $rel_interna = RelInterna::findOrFail($id)->with('relInternaDocs');

        return view('relint.formRelInt', compact('rel_interna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        if ($request->input('accion') == 'Enviar') {
            $rel_interna = RelInterna::findOrFail($id);
            $rel_interna->fecha_envio = Carbon::today()->toDateString();

            $usuario_destino = $request->input('usuario_destino');
            $grupo_destino = $request->input('grupo_destino');
            if (!empty($grupo_destino)) {
                $rel_interna->destino_id = $grupo_destino;
                $rel_interna->destino_type = 'Guia\Models\Grupo';
            } elseif (!empty($usuario_destino)) {
                $rel_interna->destino_id = $usuario_destino;
                $rel_interna->destino_type = 'Guia\User';
            }

            $rel_interna->estatus = 'Enviada';
            $rel_interna->save();
            $message = 'Relación '.$rel_interna->id.' enviada con éxito';
        }

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
