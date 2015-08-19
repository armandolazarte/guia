<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Benef;
use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Rm;
use Guia\User;

class ImportarCheques
{
    public function __construct($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id)
    {
        set_time_limit(240);
        $this->db_origen = $db_origen;

        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->cuenta_bancaria = CuentaBancaria::find($cuenta_bancaria_id);
    }

    private function crearCheque($ch_legacy)
    {
        $benef_id = $this->getBenefId($ch_legacy->benef_id);
        $cuenta_id = $this->getCuentaId($ch_legacy->concepto);
        $user_id = $this->getUserId($ch_legacy->responsable);

        //Cancelado: Crear Poliza de cancelación
        $cuenta_id == 27 ? $estatus = 'CANCELADO' : $estatus = $ch_legacy->estatus;

        $egreso = Egreso::create([
            'cuenta_bancaria_id' => $this->cuenta_bancaria->id,
            'poliza' => 0,
            'cheque' => $ch_legacy->cheque,
            'fecha' => $ch_legacy->fecha,
            'benef_id' => $benef_id,
            'cuenta_id' => $cuenta_id,
            'concepto' => '('.$ch_legacy->concepto.') '.$ch_legacy->cmt,
            'monto' => round($ch_legacy->monto,2),
            'estatus' => $estatus,
            'user_id' => $user_id,
            'fecha_cobro' => $ch_legacy->fecha_cobro
        ]);

        //Presupuesto: Importar RMs
        if ($cuenta_id == 1 && $this->db_origen == 'legacy') {
            $ch_rms_legacy = $this->getChequeRmLegacy($egreso->cheque);
            foreach ($ch_rms_legacy as $ch_rm) {
                $rm_id = Rm::whereRm($ch_rm->rm)->pluck('id');
                $egreso->rms()->attach($rm_id, ['monto' => $ch_rm->monto]);
            }
        }
    }

    public function importarChequesLegacy()
    {
        $cheques_importados = $this->getChequesImportados();

        $egresos_legacy = \DB::connection($this->db_origen)->table('tbl_cheques');
        $egresos_legacy->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria);
        if (count($cheques_importados) > 0) {
            $egresos_legacy->whereNotIn('cheque', $cheques_importados);
        }
        if (!empty($this->col_rango)) {
            $egresos_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }
        $egresos_legacy->where('concepto', 'NOT LIKE', 'Saldo%');
        $egresos_legacy->orderBy('cheque');
        $egresos_legacy->chunk(100, function($cheques_legacy) {
            foreach ($cheques_legacy as $ch_legacy) {
                $this->crearCheque($ch_legacy);
            }
        });
    }

    private function getChequesImportados()
    {
        $cheques_importados = Egreso::where('cuenta_bancaria_id', $this->cuenta_bancaria->id)
            ->lists('cheque')->all();

        return $cheques_importados;
    }

    private function getChequeRmLegacy($cheque)
    {
        $cheque_rms = \DB::connection($this->db_origen)->table('tbl_cheques_rm')
            ->where('cta_b', $this->cuenta_bancaria->cuenta_bancaria)
            ->where('cheque', $cheque)
            ->get();

        return $cheque_rms;
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
            case '':
                $concepto_id = 1;
                break;
            case 'Equivocado':
                $concepto_id = 9;//Equivocado
                break;
            case 'ReintegroDF':
            case 'DevRecursos':
                $concepto_id = 2;
                break;
            case 'Ministracion':
                $concepto_id = 3;//Recursos Presupuesto (Ministración)
                break;
            case 'Dev Intereses':
                $concepto_id = 7;//Intereses
                break;
            case 'CANCELADO':
                $concepto_id = 27;//CANCELADO
                break;
        }

        return $concepto_id;
    }
}