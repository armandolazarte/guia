<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\NoIdentificado;
use Guia\Models\Poliza;
use Guia\Models\Rm;

class ImportarReembolsos
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;
    public $cuenta_bancaria;
    public $cuentas_bancarias;
    public $reembolsos_importados;

    public function __construct($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id)
    {
        set_time_limit(240);

        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->cuenta_bancaria = CuentaBancaria::find($cuenta_bancaria_id);

        $this->db_origen = $db_origen;
        $this->getCuentasBancarias();
    }

    private function crearRegistros($i_legacy)
    {
        //Crear No Identificado
        $no_identificado = NoIdentificado::create([
            'cuenta_bancaria_id' => $this->cuenta_bancaria->id,
            'fecha' => $i_legacy->fecha,
            'monto' => $i_legacy->monto,
            'no_deposito' => '',
            'identificado' => 0
        ]);

        //Consultar identificados
        $pds_ignorar = $this->getPDsIgnorar();

        $query_legacy_identificado = \DB::connection($this->db_origen)->table('tbl_identificados')
            ->where('cta_b', $i_legacy->cta_b)
            ->where('ingreso_id', $i_legacy->ingreso_id);
        if(count($pds_ignorar) > 0) {
            $query_legacy_identificado = $query_legacy_identificado->whereNotIn('poliza', $pds_ignorar);
        }
        $legacy_identificado = $query_legacy_identificado->first();

        if (!empty($legacy_identificado->poliza)) {
            $legacy_poliza = \DB::connection($this->db_origen)->table('tbl_pd')
                ->where('poliza', $legacy_identificado->poliza)
                ->get();

            if (count($legacy_poliza) > 0) {
                $poliza = Poliza::create(['fecha' => '0000-00-00','tipo' => 'Ingreso', 'user_id' => \Auth::user()->id]);

                foreach ($legacy_poliza as $legacy_pd) {
                    if ($legacy_pd->tipo == 'eg') {
                        $legacy_egreso = \DB::connection($this->db_origen)->table('tbl_egresos')
                            ->where('cta_b', $legacy_pd->cta_b)
                            ->where('egreso_id', $legacy_pd->in_eg)
                            ->first();
                        $cuenta_id = $this->getCuentaId($legacy_egreso->concepto);
                        $poliza->polizaCargos()->create([
                            'cuenta_id' => $cuenta_id,
                            'monto' => $legacy_egreso->monto,
                            'origen_id' => $no_identificado->id,
                            'origen_type' => 'Guia\Models\NoIdentificado'
                        ]);
                    }
                    if ($legacy_pd->tipo == 'in') {
                        $legacy_ingreso = \DB::connection($this->db_origen)->table('tbl_ingresos')
                            ->where('cta_b', $legacy_pd->cta_b)
                            ->where('ingreso_id', $legacy_pd->in_eg)
                            ->first();
                        $cuenta_id = $this->getCuentaId($legacy_ingreso->concepto);

                        //-- Consulta Reembolso --//
                        $legacy_reembolso = \DB::connection($this->db_origen)->table('tbl_reembolsos')
                            ->where('cta_b', $legacy_ingreso->cta_b)
                            ->where('ingreso_id', $legacy_ingreso->ingreso_id)
                            ->first();

                        if (!empty($legacy_reembolso->ch_eg)) {

                            $this->reembolsos_importados[] = $legacy_reembolso->ingreso_id;

                            $cuenta_bancaria_id_egreso = $this->getCuentaBancariaId($legacy_reembolso->cta_b_cheg);
                            $egreso_query = Egreso::where('cuenta_bancaria_id', $cuenta_bancaria_id_egreso);
                            if ($legacy_reembolso->tipo == 'ch') {
                                $egreso_query->where('cheque', $legacy_reembolso->ch_eg);
                            } else {
                                $egreso_query->where('poliza', $legacy_reembolso->ch_eg);
                            }
                            $egreso_id = $egreso_query->pluck('id');
                            $origen_id = $egreso_id;
                            $origen_type = 'Guia\Models\Egreso';
                        } else {
                            $origen_id = '';
                            $origen_type = '';
                        }
                        //-- Fin Consulta Reembolso --//

                        $poliza_abono = $poliza->polizaAbonos()->create([
                            'cuenta_id' => $cuenta_id,
                            'monto' => $legacy_ingreso->monto,
                            'origen_id' => $origen_id,
                            'origen_type' => $origen_type
                        ]);

                        //Registrar RMs del Ingreso
                        $legacy_ingreso_rms = \DB::connection($this->db_origen)->table('tbl_ingresos_rm')
                            ->where('cta_b', $legacy_ingreso->cta_b)
                            ->where('ingreso_id', $legacy_ingreso->ingreso_id)
                            ->get();
                        if (count($legacy_ingreso_rms) > 0) {
                            foreach ($legacy_ingreso_rms as $legacy_ingreso_rm) {
                                $rm_id = Rm::whereRm($legacy_ingreso_rm->rm)->pluck('id');
                                $poliza_abono->rms()->attach($rm_id, ['monto' => $legacy_ingreso_rm->monto]);
                            }
                        }
                    }
                }
                if (!empty($legacy_ingreso)) {
                    $poliza->fecha = $legacy_ingreso->fecha;
                    $poliza->concepto = $legacy_ingreso->cmt;
                    $poliza->save();
                }
            }
        }
    }

    public function importarReembolsosFaltantes()
    {
        $legacy_reembolsos = \DB::connection($this->db_origen)->table('tbl_reembolsos')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->whereNotIn('ingreso_id', $this->reembolsos_importados)
            ->get();

        foreach ($legacy_reembolsos as $legacy_reembolso) {
            $cuenta_bancaria_id_egreso = $this->getCuentaBancariaId($legacy_reembolso->cta_b_cheg);

            $legacy_ingreso = \DB::connection($this->db_origen)->table('tbl_ingresos')
                ->where('cta_b', $legacy_reembolso->cta_b)
                ->where('ingreso_id', $legacy_reembolso->ingreso_id)
                ->first();

            if(!empty($legacy_ingreso->ingreso_id)) {

                //Crear No Identificado
                $no_identificado = NoIdentificado::create([
                    'cuenta_bancaria_id' => $this->cuenta_bancaria->id,
                    'fecha' => $legacy_ingreso->fecha,
                    'monto' => $legacy_ingreso->monto,
                    'no_deposito' => '',
                    'identificado' => 0
                ]);
                $poliza = Poliza::create([
                    'fecha' => $legacy_ingreso->fecha,
                    'tipo' => 'Ingreso',
                    'concepto' => $legacy_ingreso->cmt,
                    'user_id' => \Auth::user()->id
                ]);

                $poliza->polizaCargos()->create([
                    'cuenta_id' => 10,
                    'monto' => $legacy_ingreso->monto,
                    'origen_id' => $no_identificado->id,
                    'origen_type' => 'Guia\Models\NoIdentificado'
                ]);

                $egreso_query = Egreso::where('cuenta_bancaria_id', $cuenta_bancaria_id_egreso);
                if ($legacy_reembolso->tipo == 'ch') {
                    $egreso_query->where('cheque', $legacy_reembolso->ch_eg);
                } else {
                    $egreso_query->where('poliza', $legacy_reembolso->ch_eg);
                }
                $egreso_id = $egreso_query->pluck('id');
                $origen_id = $egreso_id;
                $origen_type = 'Guia\Models\Egreso';

                $cuenta_id = $this->getCuentaId($legacy_ingreso->concepto);
                $poliza_abono = $poliza->polizaAbonos()->create([
                    'cuenta_id' => $cuenta_id,
                    'monto' => $legacy_ingreso->monto,
                    'origen_id' => $origen_id,
                    'origen_type' => $origen_type
                ]);

                //Registrar RMs del Ingreso
                $legacy_ingreso_rms = \DB::connection($this->db_origen)->table('tbl_ingresos_rm')
                    ->where('cta_b', $legacy_ingreso->cta_b)
                    ->where('ingreso_id', $legacy_ingreso->ingreso_id)
                    ->get();
                if (count($legacy_ingreso_rms) > 0) {
                    foreach ($legacy_ingreso_rms as $legacy_ingreso_rm) {
                        $rm_id = Rm::whereRm($legacy_ingreso_rm->rm)->pluck('id');
                        $poliza_abono->rms()->attach($rm_id, ['monto' => $legacy_ingreso_rm->monto]);
                    }
                }
            }
        }
    }

    public function importarNoIdentificadosLegacy()
    {
        \DB::connection($this->db_origen)->table('tbl_ingresos')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('concepto', '=', 'No Identificado')
            //->orderBy('fecha','ingreso_id')
            ->chunk(100, function($ingresos_legacy) {
                foreach ($ingresos_legacy as $i_legacy) {
                    $this->crearRegistros($i_legacy);
                }
            });
    }

    private function getCuentaBancariaId($cta_b)
    {
        $cuenta_bancaria_id = $this->cuentas_bancarias->search($cta_b);
        return $cuenta_bancaria_id;
    }

    private function getCuentasBancarias()
    {
        $cuentas_bancarias = CuentaBancaria::all(['id','cuenta_bancaria']);
        $this->cuentas_bancarias = $cuentas_bancarias->pluck('cuenta_bancaria', 'id');
    }


    /**
     * Determina PDs relacionados c/ingresos de "Saldo *"
     *
     * @return mixed
     */
    private function getPDsIgnorar()
    {
        $legacy_ingresos_saldos = \DB::connection($this->db_origen)->table('tbl_ingresos')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('concepto', 'LIKE', 'Saldo%')
            ->lists('ingreso_id');

        $legacy_pds_ignorar = \DB::connection($this->db_origen)->table('tbl_pd')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('tipo', 'in')
            ->whereIn('in_eg', $legacy_ingresos_saldos)
            ->lists('poliza');

        return $legacy_pds_ignorar;
    }

    private function getCuentaId($legacy_concepto)
    {
        switch ($legacy_concepto) {
            case 'Presupuesto':
                $concepto_id = 1;
                break;
            case 'Equivocado':
                $concepto_id = 9;//Equivocado
                break;
            case 'No Identificado':
                $concepto_id = 10;//No Identificado
                break;
            case 'Apertura Inversion':
                $concepto_id = 6;//Invsersion
                break;
            case 'Retención ISR':
                $concepto_id = 24;
                break;
            case 'Intereses':
                $concepto_id = 7;//Intereses
                break;
            case 'Deposito Inversion':
                $concepto_id = 6;//Intereses
                break;
            case 'Ministracion':
                $concepto_id = 3;//
                break;
            case 'Pago Comisiones':
                $concepto_id = 4;//Comisiones Bancarias
                break;
            case 'PROMEP':
                $concepto_id = 11;//PROMEP
                break;
            case 'VARIOS':
                $concepto_id = 19;//Varios
                break;
            case 'Apertura de Cuenta':
                $concepto_id = 25;//Apertura de Cuenta
                break;
            case 'Devolucion Cheque':
                $concepto_id = 26;//Devolución Cheque
                break;
        }

        return $concepto_id;
    }

}
