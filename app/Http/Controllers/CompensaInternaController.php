<?php

namespace Guia\Http\Controllers;

use Guia\Models\CompensaDestino;
use Guia\Models\CompensaOrigen;
use Guia\Models\CompensaRm;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class CompensaInternaController extends Controller
{
    /**
     * Muestra el listado de compensaciones internas.
     *
     * @return Response
     */
    public function index()
    {
        $compensaciones = CompensaRm::all();

        return view('compensa.interna.indexCompensaInterna', compact('compensaciones'));
    }

    /**
     * Muestra el formulario para crear una nueva compensación.
     *
     * @return Response
     */
    public function create()
    {
        $proyectos = \FiltroAcceso::getArrProyectos();

        return view('compensa.interna.formCompensaInterna', compact('proyectos'));
    }

    /**
     * Guarda una nueva compensación.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $documento_afin = $request->input('documento_afin');
        if(empty($documento_afin)){
            $documento_afin = 0;
        }
        $fecha = \Carbon\Carbon::now()->toDateString();
        $compensa_rm = CompensaRm::create(['documento_afin' => $documento_afin, 'fecha' => $fecha, 'tipo' => 'Interna']);

        $i = 0;
        foreach ($request->input('rm_origen') as $rm_origen) {
            $monto_origen = $request->input('monto_origen')[$i];
            if($monto_origen > 0) {
                //Insertar en compsena_orgienes
                $compensa_origenes = CompensaOrigen::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm_origen, 'monto' => $monto_origen]);
            }
            $i++;
        }

        $j = 0;
        foreach ($request->input('rm_destino') as $rm_destino) {
            $monto_destino = $request->input('monto_destino')[$j];
            if($monto_destino > 0) {
                //Insertar en compsena_destinos
                $compensa_destino = CompensaDestino::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm_destino, 'monto' => $monto_destino]);
            }
            $j++;
        }

        return redirect()->action('CompensaInternaController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
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
