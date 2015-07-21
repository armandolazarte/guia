<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Articulo;
use Guia\Models\Req;

class ActualizarImpuesto
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;

    public function __construct($db_origen)
    {
        $this->db_origen = $db_origen;

        set_time_limit(240);
    }

    public function actualizarImpuesto()
    {
        $reqs_legacy = $this->consultarReqsLegacy();

        foreach ($reqs_legacy as $req) {
            $req_id = Req::whereReq($req)->pluck('id');
            $articulos = Articulo::whereReqId($req_id)->get();

            $cuadro_legacy = $this->consultarCuadroLegacy($req);

            if(count($articulos) != count($cuadro_legacy)){
                dd($req->id.' #Articulos: '.count($articulos).' #Cuadro: '.count($cuadro_legacy));
            }

            $i = 0;
            foreach ($articulos as $articulo) {
                $articulo->impuesto = $cuadro_legacy[$i]->impuesto;
                $articulo->save();
                $i++;
            }

        }
    }

    private function consultarReqsLegacy()
    {
        $reqs_legacy = \DB::connection($this->db_origen)->table('tbl_req')
            ->whereIn('estatus', ['Cotizada','Cotizando'])
            ->lists('req');

        return $reqs_legacy;
    }

    private function consultarCuadroLegacy($req)
    {
        $cuadro_legacy = \DB::connection($this->db_origen)->table('tbl_cuadro')
            ->where('req', '=', $req)
            ->get(['req','art_count','impuesto']);

        return $cuadro_legacy;
    }

}
