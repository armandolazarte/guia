<?php

namespace Guia\Http\Controllers;

use Guia\Classes\EjercicioProyecto;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class EjercicioController extends Controller
{
    public function ejercicioProyectoRms()
    {
        $proyectos = \FiltroAcceso::getArrProyectos();

        return view('ejercicio.saldoProyectoRms', compact('proyectos'));
    }

    public function getEjercicioProyectoRms()
    {
        $proyecto_id = \Input::get('proyecto_id');

        $ejercicio_proyecto = new EjercicioProyecto($proyecto_id);
        $ejercicio_rms = $ejercicio_proyecto->ejercicioRms();

        return response()->json($ejercicio_rms);
    }
}
