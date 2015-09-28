<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 22/09/2015
 * Time: 11:47 AM
 */

namespace Guia\Classes;


use Guia\Models\Proyecto;

class EjercicioProyecto
{
    public $proyecto_id;
    public $ejercicio_proyecto;

    public function __construct($proyecto_id)
    {
        $this->proyecto_id = $proyecto_id;
    }

    public function ejercicioRms()
    {
        $e_rms = new EjercicioRms();
        $ejercicio_rms = $e_rms->getEjericioRmsProyecto($this->proyecto_id);

        return $ejercicio_rms;
    }

    public function ejercicioGlobal()
    {
        $proyecto = Proyecto::findOrFail($this->proyecto_id);

        $ejercicio_global = collect(['presupuestado' => $proyecto->monto]);

        $montoReintegroDF = $this->getMontoReintegrosDF($proyecto);
        $ejercicio_global->put('reintegro_df', $montoReintegroDF);

        return $ejercicio_global;
    }

    private function getMontoReintegrosDF(Proyecto $proyecto)
    {
        $montoReintegroDF = $proyecto->egresos()->where('cuenta_id', 2)->sum('egreso_proyecto.monto');

        return round($montoReintegroDF, 2);
    }
}
