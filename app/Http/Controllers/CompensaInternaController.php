<?php

namespace Guia\Http\Controllers;

use Guia\Models\Cog;
use Guia\Models\CompensaDestino;
use Guia\Models\CompensaOrigen;
use Guia\Models\CompensaRm;
use Guia\Models\Rm;
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
        $cogs = Cog::all();

        return view('compensa.interna.formCompensaInterna', compact('proyectos','cogs'));
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

        if($request->input('monto_nuevo_rm')[0] > 0) {
            $rm_origen_id = $request->input('rm_origen')[0];
            $rmOrigen = Rm::find($rm_origen_id);
            $k = 0;
            foreach ($request->input('rm_nuevo') as $rm_nuevo) {

                $rm = new Rm();
                $rm->rm = $rm_nuevo;
                $rm->proyecto_id = $rmOrigen->proyecto_id;
                $rm->objetivo_id = $rmOrigen->objetivo_id;
                $rm->actividad_id = $rmOrigen->actividad_id;
                $rm->cog_id = $request->input('cog_nuevo')[$k];
                $rm->fondo_id = $rmOrigen->fondo_id;
                $rm->monto = 0;
                $rm->d_rm = 'Compensación #' . $compensa_rm->id;
                $rm->save();

                $monto_nuevo_rm = $request->input('monto_nuevo_rm')[$k];
                if ($monto_nuevo_rm > 0) {
                    //Insertar en compsena_destinos
                    $compensa_destino = CompensaDestino::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm->id, 'monto' => $monto_nuevo_rm]);
                }
                $k++;
            }
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
