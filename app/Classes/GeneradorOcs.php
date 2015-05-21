<?php

namespace Guia\Classes;


use Guia\Models\Articulo;
use Guia\Models\Cotizacion;
use Guia\Models\Oc;
use Guia\Models\OcsCondicion;

class GeneradorOcs {

    public $req_id;
    public $oc;
    public $arr_ocs;

    public function __construct($req_id)
    {
        $this->req_id = $req_id;
    }

    public function genera_oc(){
        $cotizaciones = Cotizacion::whereReq_id($this->req_id)->get();

        foreach($cotizaciones as $cotizacion){
            $this->oc = '';

            foreach($cotizacion->articulos as $art){

                if($art->pivot->sel == 1 && $art->oc_id == ''){

                    if(empty($this->oc)){
                        $this->oc =  \Consecutivo::nextOc();

                        $oc = new Oc();
                        $oc->req_id = $this->req_id;
                        $oc->oc = $this->oc;
                        $oc->fecha_oc = \Carbon\Carbon::now()->toDateString();;
                        $oc->benef_id = $cotizacion->benef_id;
                        $oc->save();

                        $condiciones = new OcsCondicion();
                        $condiciones->oc()->associate($oc);
                        $condiciones->save();
                    }

                    //Actualizar articulo con oc_id
                    $this->actualizar_articulo($art->id, $oc->id);
                }
            }
        }

        return $this->arr_ocs;
    }

    private function actualizar_articulo($id, $oc_id)
    {
        $articulo = Articulo::find($id);
        $articulo->oc_id = $oc_id;
        $articulo->save();
    }

}
