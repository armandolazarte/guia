<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\PagoDocumento;
use Guia\Models\Benef;
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
        $cuentas_bancarias = CuentaBancaria::all();
        $fecha = Carbon::today()->toDateString();

        $solicitudes = array();
        $solicitudes = Solicitud::whereIn('estatus',['Autorizada','Pago Parcial'])->with('proyecto', 'benef')->get();

        $reqs = array();
        $reqs = Req::whereEstatus('Autorizada')->with('ocs.benef', 'proyecto')->get();

        return view('egresos.generarEgresos', compact('solicitudes','reqs','cuentas_bancarias','fecha'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($destino, $porcentaje, $doc_type, $doc_id)
    {
        /**
         * @todo Seleccionar cuenta bancaria en función del proyecto
         */
        $data['porcentaje'] = $porcentaje;
        $data['doc_type'] = $doc_type;
        $data['doc_id'] = $doc_id;
        $data['cuentas_bancarias'] = CuentaBancaria::all()->lists('cuenta_tipo_urg','id');
        $data['cheque'] = \Consecutivo::nextCheque();

        $data['tipo_pago_sel'] = '';
        if ($destino != 'reintegro') {
            //Pago con cargo al presupuesto
            $data['benefs'] = Benef::all()->sortBy('benef')->lists('benef', 'id');
            $data['cuenta_id'] = 1;

            if ($porcentaje < 100) {
                $data['tipo_pago_sel'] = 'Parcial';
            }
            /**
             * @todo Implementar lógica para determinar selección del tipo de pago
             * Si existen otros pagos:
             *     Si Sum(monto_a_pagar_x_rm) + sum(otros_pagos) == totalAutorizado:
             *         tipo_pago_sel = 'Finiquito';
             *     else:
             *         tipo_pago_sel = 'Parcial';
             * else:
             *     tipo_pago_sel = '';
             */
            /**
             * @todo Si $doc->estatus == 'Pago Parcial' -> No listar 'Total' en tipo_pago
             */
            $data['tipo_pago'] = ['Total' => 'Total', 'Parcial' => 'Parcial', 'Finiquito' => 'Finiquito'];
        } else {
            //Reintegros
            $data['benefs'] = Benef::whereId(1)->lists('benef', 'id');
            $data['cuenta_id'] = 2;
            /**
             * @todo Si existen pagos, tipo_pago_sel = 'Reintegro Parcial'
             */
            $data['tipo_pago'] = ['Reintegro Total' => 'Reintegro Total', 'Reintegro Parcial' => 'Reintegro Parcial'];
        }

        $doc = '';
        $arr_rms = [];
        if($doc_type == 'Solicitud') {
            $doc = Solicitud::findOrFail($doc_id);
            $doc->load('rms.cog','proyecto');
            $data['concepto'] = $doc->concepto;

            //Creación de Arreglo
            foreach ($doc->rms as $rm) {
                $arr_rms[$rm->id] = ['rm' => $rm->rm , 'cog' => $rm->cog->cog, 'monto' => 0];
            }
            //Suma por Rm
            foreach ($doc->rms as $rm) {
                $arr_rms[$rm->id]['monto'] += round($rm->pivot->monto,2);
            }
        }
        if($doc_type == 'Oc') {
            $doc = Oc::findOrFail($doc_id);
            $doc->load('articulos.rms.cog','req.proyecto');
            $data['concepto'] = '';

            //Creación de Arreglo
            foreach ($doc->articulos as $articulo) {
                foreach ($articulo->rms as $rm) {
                    $arr_rms[$rm->id] = ['rm' => $rm->rm , 'cog' => $rm->cog->cog, 'monto' => 0];
                }
            }
            //Suma por Rm
            foreach ($doc->articulos as $articulo) {
                foreach ($articulo->rms as $rm) {
                    $arr_rms[$rm->id]['monto'] += round($rm->pivot->monto,2);
                }
            }
        }
        $data['doc'] = $doc;
        $data['arr_rms'] = $arr_rms;

        return view('egresos.formGeneraEgreso')->with($data);
    }

    /**
     * Genera egreso para pago total de una solicitud u orden de compra.
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
            //Creación de Arreglo
            foreach ($doc->articulos as $articulo) {
                foreach ($articulo->rms as $rm) {
                    $arr_rms[$rm->id] = 0;
                }
            }
            //Suma por Rm
            foreach ($doc->articulos as $articulo) {
                foreach ($articulo->rms as $rm) {
                    $arr_rms[$rm->id] += round($rm->pivot->monto,2);
                }
            }
            //Crea Registro
            foreach ($arr_rms as $rm_id => $monto_rm) {
                $sum_monto += $monto_rm;
                $egreso->rms()->attach($rm_id, ['monto' => $monto_rm]);
            }
            $egreso->monto = $sum_monto;
            $egreso->save();
        }

        $pago = new PagoDocumento($doc, $request->input('doc_type'));
        $pago->pagarDocumento($egreso, 'Total');

        //Inserta suma por proyecto en tabla egreso_proyecto
        $egreso_rms = $egreso->rms()->get();
        $egreso_rms = $egreso_rms->groupBy('proyecto_id');
        $egreso_rms->each(function ($item, $key) use ($egreso) {
            $egreso->proyectos()->attach($key, ['monto' => $egreso->rms()->where('proyecto_id', '=', $key)->sum('egreso_rm.monto')]);
        });

        return redirect(action('GenerarEgresoController@index'))->with(['message' => 'Cheque '.$cheque.' Generado']);

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
