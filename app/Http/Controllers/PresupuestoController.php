<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Proyecto;
use Guia\Models\Rm;
use Illuminate\Http\Request;

class PresupuestoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function saldoRms($proyecto_id, $modo_tabla = 'condensada')
	{
        if(empty($modo_tabla)){
            $modo_tabla = 'condensada';
        }

        $proyecto = Proyecto::find($proyecto_id);

		$rms = Rm::whereProyectoId($proyecto_id)
            ->with('objetivo')
            ->with('actividad')
            ->with('cog')
            ->get();

        return view('sxp.tablaSaldoRms', compact('proyecto', 'rms', 'modo_tabla'));
	}

}
