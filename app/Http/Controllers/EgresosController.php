<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\EgresoHelper;
use Guia\Classes\FiltroEstatusResponsable;
use Guia\Classes\PagoDocumento;
use Guia\Models\Benef;
use Guia\Models\Cuenta;
use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Oc;
use Guia\Models\Poliza;
use Guia\Models\Solicitud;
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
    public function index($scope = null)
    {
        $presupuesto = \Session::get('sel_presupuesto');

        //Determina Acciones Unidad de Presupuesto
        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false){
            $acciones_presupuesto = true;
        } else {
            $acciones_presupuesto = false;
        }

        if ($scope == 'asignados') {
            $filtro = new FiltroEstatusResponsable();
            $filtro->filtroEgresos();
            $egresos = Egreso::estatusResponsable($filtro->arr_estatus, $filtro->arr_responsable)
                ->withTrashed()
                ->with('benef','proyectos.fondos','cuentaBancaria','user','ocs','solicitudes')
                ->orderBy('fecha', 'DESC')
                ->paginate(100);
        } else {
            $egresos = Egreso::where('fecha', '>=', $presupuesto.'-01-01')
                ->withTrashed()
                ->with('benef','proyectos.fondos','cuentaBancaria','user','ocs','solicitudes')
                ->orderBy('fecha', 'DESC')
                ->paginate(100);
        }

        return view('egresos.indexEgresos', compact('egresos','acciones_presupuesto'));
    }

    public function indexToExcel($fecha_inicio, $fecha_fin)
    {
        $egresos = Egreso::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
            ->whereCuentaBancariaId(1)
            ->withTrashed()
            ->with('benef','proyectos.fondos','cuentaBancaria','user','ocs','solicitudes')
            ->orderBy('fecha', 'DESC')
            ->get();

        foreach ($egresos as $egreso) {
            !empty($egreso->cheque) ? $cheque_poliza = $egreso->cheque :  $cheque_poliza = $egreso->poliza;

            $proyectos = '';
            $fondos = '';
            if ($egreso->cuenta_id == 1 || $egreso->cuenta_id == 2) {
                foreach ($egreso->proyectos as $proyecto) {
                    $proyectos .= $proyecto->proyecto;
                    $fondos .= $proyecto->fondos[0]->fondo;
                }
            } else {
                $proyectos = '---';
                $fondos = '---';
            }

            $id_afin = '';
            if (count($egreso->solicitudes) > 0) {
                foreach ($egreso->solicitudes as $solicitud) {
                    $id_afin = $solicitud->no_afin;
                }
            }

            $arr_egresos[] = [
                'Cta. Bancaria' => $egreso->cuentaBancaria->cuenta_bancaria,
                'Cheque/Póliza' => $cheque_poliza,
                'Fecha' => $egreso->fecha_info,
                'Beneficiario' => $egreso->benef->benef,
                'Concepto' => $egreso->concepto,
                'Monto' => $egreso->monto,
                'Cuenta Clasificadora' => $egreso->cuenta->cuenta,
                'Proyecto' => $proyectos,
                'Fondo' => $fondos,
                'ID AFIN' => $id_afin
            ];
        }


        \Excel::create('Egresos', function($excel) use ($arr_egresos) {
            $excel->sheet('Jul-Sep', function($sheet) use ($arr_egresos) {
                $sheet->fromArray($arr_egresos);
            });
        })->download('xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $fecha = Carbon::today()->toDateString();
        $cuentas = Cuenta::whereIn('tipo', ['Ejecutora', 'Banco', 'BancoCargo'])->lists('cuenta', 'id')->all();
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id');
        $benefs = Benef::all()->sortBy('benef')->lists('benef','id');
        $cheque = \Consecutivo::nextCheque($cuentas_bancarias->keys()[0]);
        /**
         * @todo Filtrar proyecto en función de la cuenta bancaria
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
        $transferencia_bancaria = $request->input('transferencia');
        if (!isset($transferencia_bancaria)) {
            $cheque = $request->input('cheque');
            $poliza = 0;
        } else {
            $poliza = \Consecutivo::nextPolizaEgreso($request->input('cuenta_bancaria_id'));
            $cheque = 0;
        }

        $egreso = new Egreso();
        $egreso->cuenta_bancaria_id = $request->input('cuenta_bancaria_id');
        $egreso->poliza = $poliza;
        $egreso->cheque = $cheque;
        $egreso->fecha = $request->input('fecha');
        $egreso->benef_id = $request->input('benef_id');
        $egreso->cuenta_id= $request->input('cuenta_id');
        $egreso->concepto = $request->input('concepto');
        $egreso->monto = $request->input('monto');
        $egreso->user_id = \Auth::user()->id;
        $egreso->save();

        //Registro del pago del documento generador (Solicitud||Oc)
        $doc_type = $request->input('doc_type');
        $doc_id = $request->input('doc_id');
        if (!empty($doc_type) && !empty($doc_id)) {
            $documento = '';
            if ($doc_type == 'Solicitud') {
                $documento = Solicitud::find($doc_id);
            } elseif ($doc_type == 'Oc') {
                $documento = Oc::find($doc_id)->load('req');
            }

            $tipo_pago = $request->input('tipo_pago');
            if (empty($tipo_pago)) {
                $tipo_pago = 'Total';
            }
            $pago = new PagoDocumento($documento, $doc_type);
            $pago->pagarDocumento($egreso, $tipo_pago);
        }

        //Registro de monto por RM(s)
        if (count($request->input('rm_id')) > 0) {
            $i = 0;
            $monto_total = 0;
            foreach ($request->input('rm_id') as $rm_id) {
                $monto_rm = $request->input('monto_rm')[$i];
                if ($monto_rm > 0) {
                    $monto_total += $monto_rm;
                    //Insertar en egreso_rm
                    $egreso->rms()->attach($rm_id, ['monto' => $monto_rm]);
                }
                $i++;
            }
            if ($monto_total > 0) {
                $egreso->monto = $monto_total;
                $egreso->save();
            }

            $egreso_helper = new EgresoHelper($egreso);
            $egreso_helper->creaSumaPorProyecto();
        } else {
            //Fallback para solicitudes sin asignación de RM(s)
            if ($doc_type == 'Solicitud' && isset($documento)) {
                $egreso->proyectos()->attach($documento->proyecto_id, ['monto' => $request->input('monto')]);
            }
        }

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
        //Determina si se pueden borrar archivos
        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false || array_search('Contabilidad', $arr_roles) !== false){
            $borrar_archivo = true;
            $agregar_reembolsos = true;
        } else {
            $borrar_archivo = false;
            $agregar_reembolsos = false;
        }

        if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false ){
            $cancelar_cheque = true;
        } else {
            $cancelar_cheque = false;
        }

        $egreso = Egreso::withTrashed()->findOrFail($id);
        $egreso->load('ocs.archivos');
        $egreso->load('solicitudes.archivos');

        $archivos = [];
        $archivos = $egreso->archivos()->get();

        $archivos_ocs = $egreso->ocs->pluck('archivos', 'id');
        $archivos_solicitudes = $egreso->solicitudes->pluck('archivos', 'id');
        $archivos_relacionados = [];
        if(count($archivos_ocs) > 0) {
            $archivos_relacionados = $archivos_ocs;
        }
        if(count($archivos_solicitudes) > 0) {
            $archivos_relacionados = $archivos_solicitudes;
        }

        return view('egresos.infoEgreso', compact('egreso','archivos','archivos_relacionados','borrar_archivo','cancelar_cheque','agregar_reembolsos'));
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

    public function cancelar($id, Request $request)
    {
        $motivo = $request->input('motivo');
        if (empty($motivo)) {
            return redirect()->back()->with(['message' => 'Por favor especifique motivo de cancelación', 'alert-class' => 'alert-warning']);
        }

        $egreso = Egreso::findOrFail($id);
        if (empty($egreso->cheque)) {
            return redirect()->back()->with(['message' => 'Error: El egreso '.$egreso->poliza.' no es un cheque', 'alert-class' => 'alert-danger']);
        }
        /**
         * @todo Analizar caso cuando exista comprobación
         */

        //Actualiza Estatus de Solicitud || Oc&Req => Autorizada
        $pago = new PagoDocumento();
        $pago->cancelarPago($egreso);

        //Generar Póliza de Cancelación
        $poliza = Poliza::create([
            'fecha' => Carbon::today()->toDateString(),
            'tipo' => 'Cancelación',
            'concepto' => 'Cancelación Cheque '.$egreso->cheque.' '.$motivo,
            'user_id' => \Auth::user()->id
        ]);
        $poliza_abono = $poliza->polizaAbonos()->create([
            'cuenta_id' => $egreso->cuenta_id,
            'monto' => $egreso->monto,
            'origen_id' => $egreso->id,
            'origen_type' => 'Guia\Models\Egreso'
        ]);

        //Insertar RMs si existen en Egreso
        if (count($egreso->rms) > 0) {
            foreach ($egreso->rms as $rm) {
                $monto_rm = $rm->pivot->monto;
                $poliza_abono->rms()->attach($rm->id, ['monto' => $monto_rm]);
            }
        }

        $poliza->polizaCargos()->create([
            'cuenta_id' => 27,
            'monto' => $egreso->monto,
            'origen_id' => $egreso->id,
            'origen_type' => 'Guia\Models\Egreso'
        ]);

        $cheque = $egreso->cheque;
        $egreso->estatus = 'Cancelado';
        $egreso->fecha_cobro = Carbon::today()->toDateString();
        $egreso->save();
        $egreso->delete();

        return redirect()->back()->with(['message' => 'Cheque '.$cheque.' cancelado con éxito']);
    }

    public function chequeRtf($id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->load('proyectos.fondos', 'proyectos.urg');
        $arr_rms = [];
        if (count($egreso->rms) > 0) {
            foreach ($egreso->rms as $rm) {
                $arr_rms[$rm->rm] = ['cog' => $rm->cog->cog, 'monto' => 0];
            }
            foreach ($egreso->rms as $rm) {
                $arr_rms[$rm->rm]['monto'] += $rm->pivot->monto;
            }
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
