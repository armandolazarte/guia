<?php

namespace Guia\Http\Controllers;

use Guia\Models\Retencion;
use Guia\Models\Rm;
use Guia\Models\Solicitud;
use Illuminate\Http\Request;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class RetencionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($doc_id, $doc_type)
    {
        $data['doc_id'] = $doc_id;
        $data['doc_type'] = $doc_type;

        if ($doc_type == 'Solicitud') {
            $solicitud = Solicitud::find($doc_id);
        }

        $rms = Rm::whereProyectoId($solicitud->proyecto_id)
            //->whereNotIn('id', $arr_excluir)//@todo Filtrar solo RMs para retenciones
            ->get();

        $data['rms'] = $rms;

        return view('retencion.formRetencion')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Retencion::create([
            'doc_id' => $request->input('doc_id'),
            'doc_type' => $request->input('doc_type'),
            'rm_id' => $request->input('rm_id'),
            'tipo_retencion' => $request->input('tipo_retencion'),
            'monto' => $request->input('monto'),
        ]);

        if ($request->input('doc_type') == 'Solicitud') {
            $redirect_action = 'SolicitudController@show';
            $redirect_id = $request->input('doc_id');
        }

        return redirect()->action($redirect_action, $redirect_id)->with(['message' => 'Retención Capturada con éxito']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
