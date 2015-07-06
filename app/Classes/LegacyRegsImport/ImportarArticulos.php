<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Articulo;
use Guia\Models\Oc;
use Guia\Models\Req;
use Guia\Models\Rm;

class ImportarArticulos
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

    public function importarArticulos()
    {
        $reqs = Req::whereBetween('req', $this->arr_rango)
            ->get(['id', 'req', 'estatus']);

        foreach ($reqs as $req) {

            $articulos_legacy = $this->consultarArticulosLegacy($req->req);

            foreach ($articulos_legacy as $art_legacy)
            {
                if(!empty($art_legacy->oc)) {
                    $oc_id = Oc::whereOc($art_legacy->oc)->pluck('id');
                } else {
                    $oc_id = 0;
                }

                $articulo = new Articulo();
                $articulo->req_id = $req->id;
                $articulo->articulo = $art_legacy->art.' '.$art_legacy->esp;
                $articulo->cantidad = $art_legacy->cantidad;
                $articulo->impuesto = $art_legacy->impuesto;
                $articulo->monto = $art_legacy->monto;
                $articulo->oc_id = $oc_id;
                $articulo->unidad = $art_legacy->unidad;
                $articulo->inventariable = $art_legacy->alta;

                $articulo->save();

                if(!empty($art_legacy->rm)) {
                    $rm_id = Rm::whereRm($art_legacy->rm)->value('id');
                    $articulo->rms()->attach($rm_id, ['monto' => $art_legacy->monto]);
                }
            }
        }
    }

    private function consultarArticulosLegacy($req)
    {
        $articulos_legacy = \DB::connection($this->db_origen)
            ->table('tbl_req_art')
            ->join('tbl_articulos', 'tbl_req_art.art_id', '=', 'tbl_articulos.art_id')
            ->where('req', '=', $req)
            ->select('tbl_req_art.*', 'tbl_articulos.art')
            ->get();

        return $articulos_legacy;
    }

}
