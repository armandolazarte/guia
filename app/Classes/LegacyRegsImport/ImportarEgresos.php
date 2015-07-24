<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;

class ImportarEgresos
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

    private function crearEgreso($e_legacy)
    {
        $benef_id = $this->getBenefId($e_legacy->benef_id);
        $cuenta_id = $this->getCuentaId($e_legacy->concepto);
        $user_id = $this->getUserId($e_legacy->responsable);

        $egreso = Egreso::create([
            'cuenta_bancaria_id' => $this->cuenta_bancaria->id,
            'poliza' => $e_legacy->egreso_id,
            'cheque' => 0,
            'fecha' => $e_legacy->fecha,
            'benef_id' => $benef_id,
            'cuenta_id' => $cuenta_id,
            'concepto' => '('.$e_legacy->concepto.') '.$e_legacy->cmt,
            'monto' => round($e_legacy->monto,2),
            'estatus' => $e_legacy->estatus,
            'user_id' => $e_legacy->$user_id
        ]);
    }

    public function importarEgresosLegacy()
    {
        $egresos_legacy = \DB::connection($this->db_origen)->table('tbl_egresos')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('concepto', 'NOT LIKE', 'Saldo%')
            ->where('concepto', 'NOT LIKE', 'No Identificado')
            ->orderBy('fecha','egreso_id')
            ->chunk(100, function($egresos_legacy) {
                foreach ($egresos_legacy as $e_legacy) {
                    $this->crearEgreso($e_legacy);
                }
            });

//        if(!empty($this->col_rango)){
//            $egresos_legacy->whereBetween($this->col_rango, $this->arr_rango);
//        }
//        $egresos_legacy->orderBy('fecha','egreso_id');

//        return $egresos_legacy->get();
    }

    private function getBenefId($legacy_benef_id)
    {
        $benef = \DB::connection('legacy_benef')
            ->table('tbl_benef')
            ->where('benef_id', '=', $legacy_benef_id)
            ->value('benef');

        $benef_id = Benef::whereBenef($benef)->pluck('id');
        return $benef_id;
    }

    private function getUserId($legacy_user)
    {
        if($legacy_user == 'Presupuesto' || $legacy_user == '' || $legacy_user == 'Supervision') {
            $usuario = \InfoDirectivos::getResponsable('PRESU');
            $user_id = $usuario->id;
        } elseif($legacy_user == 'Contabilidad' || $legacy_user == 'Archivo' || $legacy_user == 'Blanca') {
            $usuario = \InfoDirectivos::getResponsable('CONTA');
            $user_id = $usuario->id;
        } elseif($legacy_user == 'Recepcion') {
            //Buscar primer usuario con rol recepcion
            $user_id = 345;
        } else {
            $user_id = User::whereLegacyUsername($legacy_user)->pluck('id');
        }
        if (empty($user_id)) {
            $user_id = 3;
        }

        return $user_id;
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
            case 'ReintegroDF':
            case 'DevRecursos':
                $concepto_id = 2;
                break;
            case 'IVA Com Banca en Linea':
            case 'Otras Op Banca Linea':
            case 'Com Banca en Linea':
            case 'IVA Com Ch Emitidos':
            case 'Com Ch Emitidos':
            case 'Comision por Anualidad':
            case 'IVA Comision por Anualidad':
            case 'IVA Comision Cheques Pagados':
            case 'Comision por Retencion Edo Cta':
            case 'IVA Comision por Retencion Edo':
            case 'Com Manejo Cta':
            case 'IVA Com Manejo Cta':
            case 'Comision Cheques Pagados':
            case 'Com Sobregiro':
            case 'IVA Com Sobregiro':
                $concepto_id = 4;//Comisiones Bancarias
                break;
            case 'Apertura Inversion':
                $concepto_id = 6;//Invsersion
                break;
            case 'Retención ISR':
                $concepto_id = 24;
                break;
        }

        return $concepto_id;
    }

}