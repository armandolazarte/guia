<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Egreso;
use Guia\Models\Proyecto;
use Guia\Models\Rm;
use Illuminate\Http\Request;

class PresupuestoController extends Controller {

    public function reporteEgresosProyecto($proyecto_id = null)
    {
        $proyectos = \FiltroAcceso::getArrProyectos();

        return view('egresos.reporteProyecto', compact('proyectos'));
    }

}
