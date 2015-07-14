<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Benef;
use Guia\Models\Oc;
use Guia\Models\OcsCondicion;
use Guia\Models\Req;

class ImportarOcs
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

    public function importarOcs()
    {
        $legacy_ocs = $this->consultarOcsLegacy();

        foreach ($legacy_ocs as $oc_legacy)
        {
            $benef_id = $this->getBenefId($oc_legacy->benef_id);
            $req_id = Req::whereReq($oc_legacy->req)->pluck('id');

            $oc_nueva = new Oc();
            $oc_nueva->req_id = $req_id;
            $oc_nueva->oc = $oc_legacy->oc;
            $oc_nueva->fecha_oc = $oc_legacy->fecha_oc;
            $oc_nueva->benef_id = $benef_id;
            $oc_nueva->estatus = $oc_legacy->estatus;

            $oc_nueva->save();
        }
    }

    public function actualizarCondiciones()
    {
        $legacy_ocs = $this->consultarOcsLegacy();

        foreach ($legacy_ocs as $oc_legacy)
        {
            $oc_nueva = Oc::where('oc', '=', $oc_legacy->oc)->first();
            $this->relacionarCondiciones($oc_legacy->oc, $oc_nueva);
        }
    }

    private function relacionarCondiciones($oc,Oc $oc_nueva)
    {
        $condiciones_legacy = $this->consultarCondicionesLegacy($oc);

        if(count($condiciones_legacy) > 0) {
            $condiciones_nueva = new OcsCondicion([
                'forma_pago' => $condiciones_legacy->forma_pago,
                'fecha_entrega' => $condiciones_legacy->fecha_entrega,
                'pago' => $condiciones_legacy->pago,
                'no_parcialidades' => $condiciones_legacy->no_parcialidades,
                'porcentaje_anticipo' => $condiciones_legacy->porcentaje_anticipo,
                'fecha_inicio' => $condiciones_legacy->fecha_inicio,
                'fecha_conclusion' => $condiciones_legacy->fecha_conclusion,
                'fianzas' => $condiciones_legacy->fianzas,
                'obs' => $condiciones_legacy->obs,
            ]);

            $oc_nueva->condiciones()->save($condiciones_nueva);

        } else {
            $condiciones = new OcsCondicion();
            $condiciones->oc()->associate($oc_nueva);
            $condiciones->save();
        }
    }

    private function consultarCondicionesLegacy($oc = null)
    {
        $condiciones_legacy = \DB::connection($this->db_origen)->table('tbl_condiciones');
        if(!empty($this->col_rango)) {
            $condiciones_legacy->where('oc', '=', $oc);
        }

        return $condiciones_legacy->first();
    }

    private function consultarOcsLegacy()
    {
        $ocs_legacy = \DB::connection($this->db_origen)->table('tbl_oc');
        if(!empty($this->col_rango)){
            $ocs_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }

        return $ocs_legacy->get();
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
}
