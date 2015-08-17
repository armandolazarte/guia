<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Ingreso;
use Guia\Models\Rm;

class ImportarIngresos
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;
    public $cuenta_bancaria;

    public function __construct($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id)
    {
        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->cuenta_bancaria = CuentaBancaria::find($cuenta_bancaria_id);

        $this->db_origen = $db_origen;
    }

    private function crearIngreso($i_legacy)
    {
        $cuenta_id = $this->getCuentaId($i_legacy->concepto);

        $ingreso = Ingreso::create([
            'cuenta_bancaria_id' => $this->cuenta_bancaria->id,
            'poliza' => $i_legacy->ingreso_id,
            'fecha' => $i_legacy->fecha,
            'cuenta_id' => $cuenta_id,
            'concepto' => '('.$i_legacy->concepto.') '.$i_legacy->cmt,
            'monto' => round($i_legacy->monto,2)
        ]);

        //Presupuesto: Importar RMs
        if ($cuenta_id == 1 && $this->db_origen == 'legacy') {
            $ingreso_rms_legacy = $this->getIngresoRmLegacy($ingreso->ingreso_id);
            foreach ($ingreso_rms_legacy as $in_rm) {
                $rm_id = Rm::whereRm($in_rm->rm)->pluck('id');
                $ingreso->rms()->attach($rm_id, ['monto' => $in_rm->monto]);
            }
        }
    }

    public function importarIngresosLegacy()
    {
        \DB::connection($this->db_origen)->table('tbl_ingresos')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('concepto', 'NOT LIKE', 'Saldo%')
            ->where('concepto', 'NOT LIKE', 'No Identificado')
            ->where('concepto', 'NOT LIKE', 'VARIOS')
            ->orderBy('fecha','ingreso_id')
            ->chunk(100, function($ingresos_legacy) {
                foreach ($ingresos_legacy as $i_legacy) {
                    $this->crearIngreso($i_legacy);
                }
            });
    }

    private function getIngresoRmLegacy($ingreso_id)
    {
        $ingreso_rms = \DB::connection($this->db_origen)->table('tbl_ingresos_rm')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('ingreso_id', $ingreso_id)
            ->get();

        return $ingreso_rms;
    }

    private function getCuentaId($legacy_concepto)
    {
        switch($legacy_concepto) {
            case 'Presupuesto':
                $concepto_id = 1;
                break;
            case 'Equivocado':
                $concepto_id = 9;//Equivocado
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