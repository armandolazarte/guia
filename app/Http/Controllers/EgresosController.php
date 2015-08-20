<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Benef;
use Guia\Models\Cuenta;
use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Nat\Nat;

class EgresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $presupuesto = \Session::get('sel_presupuesto');

        $egresos = Egreso::where('fecha', '>=', $presupuesto.'-01-01')
            ->orderBy('cheque', 'desc')
            ->paginate(50);
        $egresos->load('benef');
        $egresos->load('rms');
        $egresos->load('cuentaBancaria');
        $egresos->load('user');

        return view('egresos.indexEgresos', compact('egresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $fecha = Carbon::today()->toDateString();
        $cuentas = Cuenta::whereIn('tipo', ['Ejecutora'])->lists('cuenta', 'id')->all();
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id');
        $benefs = Benef::all()->sortBy('benef')->lists('benef','id');
        $cheque = \Consecutivo::nextCheque();

        /**
         * @todo Monto por RM
         * @todo Clonar selección de RM
         * @todo Calcular monto total utilizando montos parciales por RM
         */

        return view('egresos.formEgreso', compact('fecha','cuentas','cuentas_bancarias','benefs','cheque'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\EgresoFormRequest $request)
    {
        $request->merge(array(
            'user_id' => \Auth::user()->id,
        ));

        $egreso = Egreso::create($request->all());
        return redirect()->action('EgresosController@show', [$egreso->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $egreso = Egreso::findOrFail($id);

        return view('egresos.infoEgreso', compact('egreso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $egreso = Egreso::findOrFail($id);

        $cuentas = Cuenta::whereIn('tipo', ['Ejecutora'])->lists('cuenta', 'id')->all();
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id');
        $benefs = Benef::all()->sortBy('benef')->lists('benef','id');
        $fecha = null;
        $cheque = null;

        return view('egresos.formEgreso', compact('egreso','fecha','cheque','cuentas','cuentas_bancarias','benefs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\EgresoFormRequest $request)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->update([
            'fecha' => $request->input('fecha'),
            'cuenta_bancaria_id' => $request->input('cuenta_bancaria_id'),
            'benef_id' => $request->input('benef_id'),
            'cheque' => $request->input('cheque'),
            'concepto' => $request->input('concepto'),
        ]);
        $egreso->save();

        return redirect()->action('EgresosController@index');
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

    public function chequeRtf($id)
    {
        $egreso = Egreso::findOrFail($id);
        $arr_rms = [];
        foreach ($egreso->rms as $rm) {
            $arr_rms[$rm->rm] = ['cog' => $rm->cog->cog, 'monto' => 0];
        }
        foreach ($egreso->rms as $rm) {
            $arr_rms[$rm->rm]['monto'] += $rm->pivot->monto;
        }
        $fecha_texto = \Utility::fecha_texto($egreso->fecha);
        $nat = new Nat(round($egreso->monto, 2), '');
        $monto_letra = $nat->convertir();

        $presu = \InfoDirectivos::getResponsable('PRESU')->iniciales;
        $cfin = \InfoDirectivos::getResponsable('FIN')->iniciales;
        $elabora = \Auth::user()->iniciales;

        return view('egresos.formCheque', compact('egreso', 'monto_letra', 'fecha_texto','presu','cfin','elabora','arr_rms'));
    }
}
