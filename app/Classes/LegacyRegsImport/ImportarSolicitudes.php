<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Benef;
use Guia\Models\Objetivo;
use Guia\Models\Proyecto;
use Guia\Models\Rm;
use Guia\Models\Solicitud;
use Guia\User;

class ImportarSolicitudes {

    public $db_origen;
    public $arr_rango;
    public $col_rango;

    public function __construct($db_origen, $col_rango, $arr_rango)
    {
        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        if(!empty($id_fin)) {
            $this->id_fin = $id_fin;
        }

        $this->db_origen = $db_origen;
    }

    public function importarSolicitudes()
    {
        $solicitudes_legacy = $this->consultarSolicitudesLegacy();

        foreach ($solicitudes_legacy as $sol_legacy) {

            $benef = \DB::connection('legacy_benef')
                ->table('tbl_benef')
                ->where('benef_id', '=', $sol_legacy->benef_id)
                ->value('benef');

            $benef_id = Benef::whereBenef($benef)->pluck('id');
            $proyecto = Proyecto::whereProyecto($sol_legacy->proy)->get(['id','urg_id']);

            //Determinar el ID del usuario solicitante
            $solicita_id = User::whereLegacyUsername($sol_legacy->solicita)->pluck('id');

            //Determinar el usuario responsable
            if($sol_legacy->responsable == 'Presupuesto') {
                $usuario = \InfoDirectivos::getResponsable('PRESU');
                $user_id = $usuario->id;
            } elseif($sol_legacy->responsable == 'Contabilidad') {
                $usuario = \InfoDirectivos::getResponsable('CONTA');
                $user_id = $usuario->id;
            } elseif($sol_legacy->responsable == 'Recepcion') {
                //Buscar primer usuario con rol recepcion
                $user_id = 2;
            } else {
                $user_id = User::whereLegacyUsername($sol_legacy->responsable)->pluck('id');
            }

            $sol_nueva = new Solicitud();
            $sol_nueva->fecha = $sol_legacy->fecha;
            $sol_nueva->benef_id = $benef_id;
            $sol_nueva->tipo_solicitud = $sol_legacy->tipo_solicitud;
            $sol_nueva->urg_id = $proyecto[0]->urg_id;
            $sol_nueva->proyecto_id = $proyecto[0]->id;
            $sol_nueva->concepto = $sol_legacy->concepto;
            $sol_nueva->obs = $sol_legacy->obs. ' #SIGI: '.$sol_legacy->solicitud_id;
            $sol_nueva->no_documento = $sol_legacy->no_documento;
            $sol_nueva->no_afin = $sol_legacy->id_afin;
            $sol_nueva->monto = $sol_legacy->monto;
            $sol_nueva->solicita = $solicita_id;
            $sol_nueva->estatus = $sol_legacy->estatus;
            $sol_nueva->user_id = $user_id;//responsable
            $sol_nueva->monto_pagado = $sol_legacy->monto_pagado;
            $sol_nueva->viaticos = $sol_legacy->viaticos;
            $sol_nueva->inventariable = $sol_legacy->inventariable;

            $sol_nueva->save();

            if ($sol_nueva->estatus != 'Cancelada') {
                if ($sol_legacy->tipo_solicitud != 'Vale') {
                    $rms_solicitud = $this->consutlarRMs($sol_legacy->solicitud_id);
                    foreach ($rms_solicitud as $rm_legacy) {
                        $rm_id = Rm::whereRm($rm_legacy->rm)->value('id');
                        $sol_nueva->rms()->attach($rm_id, ['monto' => $rm_legacy->monto]);
                    }
                } else {
                    //Buscar si tiene capturado el objetivo
                    $objs_solicitud = $this->consultarObjetivos($sol_legacy->solicitud_id);
                    if(count($objs_solicitud) > 0) {
                        foreach ($objs_solicitud as $obj_legacy) {
                            $objetivo_id = Objetivo::whereObjetivo($obj_legacy)->value('id');
                            $sol_nueva->objetivos()->attach($objetivo_id, ['monto' => $obj_legacy->monto]);
                        }

                    } else {//Si no, asigna primer objetivo que encuentre en el proyecto
                        $objetivo_id = Rm::whereProyectoId($sol_nueva->proyecto_id)->value('objetivo_id');
                        $sol_nueva->objetivos()->attach($objetivo_id, ['monto' => $sol_nueva->monto]);
                    }
                }
            }
        }
    }

    private function consultarSolicitudesLegacy()
    {
        $solicitudes_legacy = \DB::connection($this->db_origen)->table('tbl_solicitud');
        if(!empty($this->col_rango)){
            $solicitudes_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }


        return $solicitudes_legacy->get();
    }

    private function consutlarRMs($solicitud_id)
    {
        $rms_solicitud = \DB::connection($this->db_origen)->table('tbl_solicitud_rm')
            ->where('solicitud_id', '=', $solicitud_id)
            ->get();

        return $rms_solicitud;
    }

    private function consultarObjetivos($solicitud_id)
    {
        $objs_solicitud = \DB::connection($this->db_origen)->table('tbl_solicitud_objetivo')
            ->where('solicitud_id', '=', $solicitud_id)
            ->get();

        return $objs_solicitud;
    }
}