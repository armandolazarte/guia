<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Solicitud;
use Guia\Models\Rm;
use Guia\Models\Objetivo;
use Guia\Http\Requests\SolicitudRecursosRequest;
use Illuminate\Http\Request;

/**
 * Class SolicitudRecursosController
 * @package Guia\Http\Controllers
 */
class SolicitudRecursosController extends Controller {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
        $solicitud = Solicitud::find($id);
        $data['solicitud'] = $solicitud;

        //Determina rm_id ya registrados en la solicitud para impedir cargos duplicados
        $arr_excluir = array();
        $rms_registrados = $solicitud->rms;
        foreach ($rms_registrados as $rm_excluir){
            $arr_excluir[] = $rm_excluir->id;
        }

        $rms = Rm::whereProyectoId($solicitud->proyecto_id)->whereNotIn('id', $arr_excluir)->get();
        if (count($rms) > 0){
            $rms->load('cog');
        } else {
            return redirect()->back()->with('message', 'Todos los Recursos Materiales han sido asignados');
        }
        $data['objetivos'] = [];
        $data['rms'] = $rms;

        return view('solicitudes.formSolRecurso')->with($data);
	}

	/**
	 * Guarda el monto por RM/Objetivo de una solicitud
	 *
	 * @return Response
	 */
	public function store(SolicitudRecursosRequest $request)
	{
        $solicitud = Solicitud::find($request->input('solicitud_id'));
        $solicitud->rms()->attach($request->input('rm_id'), array('monto' => $request->input('monto')));

        $solicitud->monto = $this->getMontoTotal($solicitud);
        $solicitud->save();

        return redirect()->action('SolicitudController@show', array($solicitud->id));
	}

	/**
	 * Muestra el formulario para editar el monto por RM/Objetivo de una solicitud.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($solicitud_id, $recurso_id)
	{
        $solicitud = Solicitud::find($solicitud_id);
        $data['solicitud'] = $solicitud;
        $data['recurso_id'] = $recurso_id;

        if ( count($solicitud->objetivos) > 0 ) {
            $objetivos = $solicitud->objetivos()->whereObjetivoId($recurso_id)->get();
            $data['objetivos'] = $objetivos;
            $data['monto'] = $objetivos[0]->pivot->monto;
        } else {
            $data['objetivos'] = [];
            $rms = $solicitud->rms()->whereRmId($recurso_id)->get();
            $data['rms'] = $rms;
            $data['monto'] = $rms[0]->pivot->monto;
        }

		return view('solicitudes.formSolRecurso')->with($data);
	}

	/**
	 * Actualiza el monto de un recurso (RM/Objetivo) de una solicitud.
	 *
	 * @param  int  $solicitud_id
     * @param  int  $recurso_id
	 * @return Response
	 */
	public function update($solicitud_id, $recurso_id, SolicitudRecursosRequest $request)
	{
        $solicitud = Solicitud::findOrFail($solicitud_id);
        $solicitud->rms()->updateExistingPivot($recurso_id, array('monto' => $request->input('monto')));

        $solicitud->monto = $this->getMontoTotal($solicitud);
        $solicitud->save();

        return redirect()->action('SolicitudController@show', array($solicitud->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($solicitud_id, $recurso_id)
	{
        $solicitud = Solicitud::findOrFail($solicitud_id);
        if ( count($solicitud->objetivos) > 0 ) {
            $solicitud->objetivos()->detach($recurso_id);
        } else {
            $solicitud->rms()->detach($recurso_id);
        }

        $solicitud->monto = $this->getMontoTotal($solicitud);
        $solicitud->save();

        return redirect()->action('SolicitudController@show', array($solicitud->id));
	}

    private function getMontoTotal(Solicitud $solicitud)
    {
        $monto_total = 0;
        foreach($solicitud->rms as $rm){
            $monto_total += $rm->pivot->monto;
        }
        return $monto_total;
    }

}
