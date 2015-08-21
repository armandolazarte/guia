<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Oc;
use Guia\Models\Req;
use Guia\Models\Solicitud;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class GenerarEgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cuentas_bancarias = CuentaBancaria::all();
        $fecha = Carbon::today()->toDateString();

        $solicitudes = array();
        $solicitudes = Solicitud::whereEstatus('Autorizada')->with('proyecto', 'benef')->get();

        $reqs = array();
        $reqs = Req::whereEstatus('Autorizada')->with('ocs.benef', 'proyecto')->get();

        return view('egresos.generarEgresos', compact('solicitudes','reqs','cuentas_bancarias','fecha'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        if($request->input('doc_type') == 'Solicitud') {
            $doc = Solicitud::findOrFail($request->input('doc_id'));

            $benef_id = $doc->benef_id;
            $concepto = $doc->concepto;
            $monto = $doc->monto;

            $ocultar_id = 'sol-'.$request->input('doc_id');
            $message = "Solicitud ".$request->input('doc_id')." agregada";
        }
        if($request->input('doc_type') == 'Oc') {
            $doc = Oc::findOrFail($request->input('doc_id'));
            $doc->load('articulos.rms');

            $benef_id = $doc->benef_id;
            $concepto = '';
            /**
             * @todo Determinar Monto de OC
             */
            $monto = 0;

            $ocultar_id = 'oc-'.$request->input('doc_id');
            $message = "Orden de Compra ".$doc->oc." agregada";
        }

        $tipo_egreso = $request->input('tipo_egreso');
        if ($tipo_egreso == 'cheque') {
            $cheque = $request->input('cheque');
            if (empty($cheque)) {
                $cheque = \Consecutivo::nextCheque();
            }
            $poliza = 0;
        } else {
            $egreos = $request->input('poliza');
            if (empty($poliza)) {
                $poliza = \Consecutivo::nextPolizaEgreso();
            }
            $cheque = 0;
        }

        $egreso = new Egreso();
        $egreso->cuenta_bancaria_id = $request->input('cuenta_bancaria_id');
        $egreso->poliza = $poliza;
        $egreso->cheque = $cheque;
        $egreso->fecha = $request->input('fecha');
        $egreso->benef_id = $benef_id;
        $egreso->cuenta_id= 1;//Presupuesto
        $egreso->concepto = $concepto;
        $egreso->monto = $monto;
        $egreso->user_id = \Auth::user()->id;
        $egreso->save();

        if($request->input('doc_type') == 'Solicitud') {
            $rms = $doc->rms;
            foreach ($rms as $rm) {
                $monto_rm = $rm->pivot->monto;
                $egreso->rms()->attach($rm->id, ['monto' => $monto_rm]);
            }
        } else {
            $sum_monto = 0;
            foreach ($doc->articulos as $art) {
                foreach ($art->rms as $rm) {
                    $monto_rm = $rm->pivot->monto;
                    $sum_monto += $monto_rm;
                    $egreso->rms()->attach($rm->id, ['monto' => $monto_rm]);
                }
            }
            $egreso->monto = $sum_monto;
            $egreso->save();
        }

        $doc->egresos()->save($egreso);
        $doc->estatus = 'Pagada';
        $doc->save();

        //Inserta suma por proyecto en tabla egreso_proyecto
        $egreso_rms = $egreso->rms()->get();
        $egreso_rms = $egreso_rms->groupBy('proyecto_id');
        $egreso_rms->each(function ($item, $key) use ($egreso) {
            $egreso->proyectos()->attach($key, ['monto' => $egreso->rms()->where('proyecto_id', '=', $key)->sum('egreso_rm.monto')]);
        });

        return redirect(action('GenerarEgresoController@create'))->with(['message' => 'Cheque '.$cheque.' Generado']);

//        if($request->ajax()) {
//            return response()->json([
//                'message' => $message,
//                'ocultar' => $ocultar_id
//            ]);
//        }
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
