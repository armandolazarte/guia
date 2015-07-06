<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Proyecto;
use Guia\Models\Req;
use Guia\User;

class ImportarReqs
{

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

    public function importarReqs()
    {
        $reqs_legacy = $this->consultarReqsLegacy();

        foreach ($reqs_legacy as $req_legacy) {
            $proyecto = Proyecto::whereProyecto($req_legacy->proy)->get(['id','urg_id']);

            //Determinar el ID del usuario solicitante
            $solicita_id = User::whereLegacyUsername($req_legacy->solicita)->pluck('id');

            //Determinar el ID del usuario autoriza
            if(!empty($req_legacy->autoriza)) {
                $autoriza_id = User::whereLegacyUsername($req_legacy->autoriza)->pluck('id');
            } else {
                $autoriza_id = 0;
            }

            //Determinar el usuario responsable
            if(!empty($req_legacy->responsable)) {
                $user_id = User::whereLegacyUsername($req_legacy->responsable)->pluck('id');
            } else {
                $user_id = 0;
            }

            $req_nueva = new Req();
            $req_nueva->req = $req_legacy->req;
            $req_nueva->fecha_req = $req_legacy->fecha_req;
            $req_nueva->urg_id = $proyecto[0]->urg_id;
            $req_nueva->proyecto_id = $proyecto[0]->id;
            $req_nueva->etiqueta = $req_legacy->etiqueta;
            $req_nueva->lugar_entrega = $req_legacy->lugar_entrega;
            $req_nueva->obs = $req_legacy->obs;
            $req_nueva->solicita = $solicita_id;
            $req_nueva->autoriza = $autoriza_id;
            $req_nueva->estatus = $req_legacy->estatus;
            $req_nueva->user_id = $user_id;
            $req_nueva->tipo_cambio = $req_legacy->tc;
            $req_nueva->moneda = $req_legacy->moneda;
            $req_nueva->tipo_orden = $req_legacy->tipo_orden;

            $req_nueva->save();
        }
    }

    private function consultarReqsLegacy()
    {
        $reqs_legacy = \DB::connection($this->db_origen)->table('tbl_req');
        if(!empty($this->col_rango)){
            $reqs_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }

        return $reqs_legacy->get();
    }



}
