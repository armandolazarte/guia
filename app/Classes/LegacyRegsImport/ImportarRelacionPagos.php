<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 06/09/2015
 * Time: 07:11 PM
 */

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Oc;
use Guia\Models\Solicitud;

class ImportarRelacionPagos
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;
    public $cuentas_bancarias;

    public function __construct($db_origen, $col_rango, $arr_rango)
    {
        set_time_limit(240);
        $this->db_origen = $db_origen;

        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->getCuentasBancarias();
    }

    private function registrarPagoOc($pago_oc_legacy)
    {
        //Encontrar oc_id
        $oc_id = Oc::whereOc($pago_oc_legacy->oc)->pluck('id');

        if(!empty($oc_id)) {
            //Enconrar egreso_id
            $cuenta_bancaria_id = $this->getCuentaBancariaId($pago_oc_legacy->cta_b);
            if(!empty($cuenta_bancaria_id)) {
                $egreso = Egreso::where('cuenta_bancaria_id', '=', $cuenta_bancaria_id);
                if ($pago_oc_legacy->tipo == 'ch') {
                    $egreso->where('cheque', '=', $pago_oc_legacy->ch_eg);
                } else {
                    $egreso->where('poliza', '=', $pago_oc_legacy->ch_eg);
                }
                try {
                    $egreso = $egreso->firstOrFail();
                } catch (\ModelNotFoundException $e) {
                    dd('Egreso no encontrado ' . $pago_oc_legacy->ch_eg . ' Cta.B. ' . $pago_oc_legacy->cta_b . ' ERROR: ' . $e);
                }

                //Crear Relación
                $egreso->ocs()->attach($oc_id);
            }

        } else {
            dd('No se encontró la OC '.$pago_oc_legacy->oc);
        }

    }

    public function importarPagoOcs()
    {
        $pago_ocs_legacy = \DB::connection($this->db_origen)->table('tbl_oc_cheg');
        if (!empty($this->col_rango)) {
            $pago_ocs_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }
        $pago_ocs_legacy->chunk(100, function($pagos_oc_legacy) {
            foreach ($pagos_oc_legacy as $pago_oc_legacy) {
                $this->registrarPagoOc($pago_oc_legacy);
            }
        });
    }

    private function registrarPagoSolicitud($pago_sol_legacy)
    {
        //Encontrar solicitud_id
        $solicitud_id = Solicitud::where('obs', 'LIKE', '% #SIGI: '.$pago_sol_legacy->solicitud_id)->pluck('id');

        if(!empty($solicitud_id)){
            //Enconrar egreso_id
            $cuenta_bancaria_id = $this->getCuentaBancariaId($pago_sol_legacy->cta_b);
            if(!empty($cuenta_bancaria_id)) {
                $egreso = Egreso::where('cuenta_bancaria_id', '=', $cuenta_bancaria_id);
                if($pago_sol_legacy->tipo == 'ch') {
                    $egreso->where('cheque', '=', $pago_sol_legacy->poliza);
                } else {
                    $egreso->where('poliza', '=', $pago_sol_legacy->poliza);
                }

                $egreso = $egreso->first();

                if(empty($egreso->id)) {
                    dd('Egreso no encontrado '.$pago_sol_legacy->poliza);
                }

                //Crear Relación
                $egreso->solicitudes()->attach($solicitud_id);
            }
        } else {
            dd('No se encontró la Solicitud '.$pago_sol_legacy->solicitud_id);
        }
    }

    public function importarPagoSolicitudes()
    {
        $pago_solicitudes_legacy = \DB::connection($this->db_origen)->table('tbl_solicitud_pago');
        if (!empty($this->col_rango)) {
            $pago_solicitudes_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }
        $pago_solicitudes_legacy->chunk(100, function($pagos_sol_legacy) {
            foreach ($pagos_sol_legacy as $pago_sol_legacy) {
                $this->registrarPagoSolicitud($pago_sol_legacy);
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

}