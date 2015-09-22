<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 22/09/2015
 * Time: 11:47 AM
 */

namespace Guia\Classes;


class EjercicioProyecto
{
    public $proyecto_id;

    public function __construct($proyecto_id)
    {
        $this->proyecto_id = $proyecto_id;
    }

    public function ejercicioRms()
    {
        $e_rms = new EjercicioRms();
        $ejercicio_rms = $e_rms->getEjericioProyecto($this->proyecto_id);

        return $ejercicio_rms;
    }
}
