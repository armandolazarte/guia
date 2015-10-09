<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Egreso;
use Guia\Models\NoIdentificado;
use Guia\Models\Poliza;
use Guia\Models\Rm;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class PolizaController extends Controller
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
    public function create($tipo, $egreso_id = null, $opciones = null)
    {
        if ($tipo == 'ingreso' && !empty($egreso_id)) {
            $egreso = Egreso::find($egreso_id);
            $egreso->load('rms.cog');

            $arr_rms = [];
            foreach ($egreso->rms as $rm) {
                $arr_rms[$rm->id] = ['rm' => $rm->rm, 'cog' => $rm->cog->cog];
            }

            /**
             * @todo Consultar otras posibles identificaciones del deósito para determinar solo el saldo x identificar
             */
            $no_identificados = NoIdentificado::where('identificado', 0)
                //->where('fecha', '>=', $egreso->fecha)
                ->orderBy('fecha', 'DESC')
                ->get()->lists('fecha_monto', 'id');

            return view('polizas.formIngresoReemEgreso', compact('egreso','no_identificados','arr_rms'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $tipo = $request->input('tipo');
        $egreso_id = $request->input('egreso_id');

        if ($tipo == 'Ingreso' && !empty($egreso_id)) {

            $no_identificado_id = $request->input('no_identificado_id');
            $no_identificado = NoIdentificado::findOrFail($no_identificado_id);
            $egreso = Egreso::findOrFail($egreso_id);
            $egreso->load('rms');

            //Determina el monto total
            $sum_monto = 0;
            $arr_monto_rms = [];
            foreach ($egreso->rms as $rm) {
                $monto_rm_id = $request->input('monto_rm_id_'.$rm->id);
                if (!empty($monto_rm_id)) {
                    $arr_monto_rms[$rm->id] = $monto_rm_id;
                }
            }

            //Determina el monto total
            foreach ($arr_monto_rms as $monto_rm) {
                $sum_monto += $monto_rm;
            }

            //Generar Póliza
            $poliza = Poliza::create([
                'cuenta_bancaria_id' => $no_identificado->cuenta_bancaria_id,
                'fecha' => Carbon::now()->toDateString(),
                'tipo' => $tipo,
                'user_id' => \Auth::user()->id
            ]);

            //Generar Cargo (cuenta_id => 10 //No Identificado)
            $poliza->polizaCargos()->create([
                'cuenta_id' => 10,
                'monto' => $sum_monto,
                'origen_id' => $no_identificado_id,
                'origen_type' => 'Guia\Models\NoIdentificado'
            ]);

            //Generar Abono
            $poliza_abono = $poliza->polizaAbonos()->create([
                'cuenta_id' => $egreso->cuenta_id,
                'monto' => $sum_monto,
                'origen_id' => $egreso_id,
                'origen_type' => 'Guia\Models\Egreso'
            ]);

            //Insertar RMs
            foreach ($arr_monto_rms as $rm => $monto) {
                $poliza_abono->rms()->attach($rm, ['monto' => $monto]);
            }

            //Actualizar NoIdentificado
            if (round($no_identificado->monto, 2) == round($sum_monto, 2)) {
                $no_identificado->identificado = 1;
                $no_identificado->fecha_identificado = Carbon::now()->toDateString();
                $no_identificado->save();
            }

            return redirect()->action('EgresosController@show', $egreso_id)->with(['message' => 'Póliza de Ingreso creada con éxito']);
        } else {
            return redirect()->back()->with(['message' => 'No se puede realizar esta acción']);
        }
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
