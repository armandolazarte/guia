<?php

namespace Guia\Classes;


use Guia\Models\Rm;
use Illuminate\Support\Collection;

class ArticulosHelper
{
    public $articulos;
    public $articulos_sin_rms;
    public $articulos_con_rms;
    public $rms_articulos;

    public function __construct(Collection $articulos)
    {
        $this->articulos = $articulos;
    }

    public function setArticulosSinRms()
    {
        //Determinar artículos que no tienen RMs asignado
        $this->articulos_sin_rms = $this->articulos->reject(function ($articulos) {
            return $articulos->rms->count() > 0;
        });
    }

    public function setArticulosConRms()
    {
        //Determinar artículos que tienen RMs asignado
        $this->articulos_con_rms = $this->articulos->filter(function ($articulos) {
            return $articulos->rms->count() > 0;
        });
    }

    public function setRmsArticulos()
    {
        $this->setArticulosConRms();
        //Crea arreglo con IDs de los RMs de los artículos
        $arr_rms_ids = [];
        foreach ($this->articulos_con_rms as $articulo) {
            foreach ($articulo->rms as $rm) {
                $arr_rms_ids[] = $rm->id;
            }
        }

        //Consulta los artículos desde tabla rms
        $rms_articulos = Rm::whereIn('id', $arr_rms_ids)->orderBy('rm')->with('articulos')->with('cog')->get();

        //Ordena artículos por COG
        $this->rms_articulos  = $rms_articulos->sortBy(function ($rms_articulos) {
            return $rms_articulos->cog->cog;
        });
    }

}
