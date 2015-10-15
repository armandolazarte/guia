<?php

namespace Guia\Classes;


use Guia\Models\Egreso;

class EgresoHelper
{
    public $egreso;

    public function __construct(Egreso $egreso) {
        $this->egreso = $egreso;
    }

    public function creaSumaPorProyecto() {
        //Inserta suma por proyecto en tabla egreso_proyecto
        $egreso_rms = $this->egreso->rms()->get();
        $egreso_rms = $egreso_rms->groupBy('proyecto_id');
        $egreso_rms->each(function ($item, $key) {
            $this->egreso->proyectos()->attach($key, ['monto' => $this->egreso->rms()->where('proyecto_id', '=', $key)->sum('egreso_rm.monto')]);
        });
    }
}