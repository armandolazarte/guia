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

        if ($solicitud->tipo_solicitud == "Vale") {
            //Determina objetivo_id ya registrados en la solicitud para impedir cargos duplicados
            $arr_excluir = array();
            $objetivos_registrados = $solicitud->objetivos;
            foreach ($objetivos_registrados as $obj_excluir){
                $arr_excluir[] = $obj_excluir->id;
            }

            $arr_objetivos_id = Rm::distinct()->whereProyectoId($solicitud->proyecto_id)->whereNotIn('objetivo_id', $arr_excluir)->lists('objetivo_id');
            $objetivos = Objetivo::whereIn('id', $arr_objetivos_id)->get();
            if (count($objetivos) == 0){
                return redirect()->back()->with('message', 'Todos los Objetivos han sido asignados');
            }
            $data['objetivos'] = $objetivos;
        } else {
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
            $data['rms'] = $rms;
        }

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

        if ( $solicitud->tipo_solicitud == 'Vale' ) {
            $solicitud->objetivos()->attach($request->input('objetivo_id'), array('monto' => $request->input('monto')));
        } else {
            $solicitud->rms()->attach($request->input('rm_id'), array('monto' => $request->input('monto')));
        }

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

        if ( $solicitud->tipo_solicitud == 'Vale' ) {
            $objetivos = $solicitud->objetivos()->whereObjetivoId($recurso_id)->get();
            $data['objetivos'] = $objetivos;
            $data['monto'] = $objetivos[0]->pivot->monto;
        } else {
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
        if ( $solicitud->tipo_solicitud == 'Vale' ) {
            $solicitud->objetivos()->updateExistingPivot($recurso_id, array('monto' => $request->input('monto')));
        } else {
            $solicitud->rms()->updateExistingPivot($recurso_id, array('monto' => $request->input('monto')));
        }

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
        if ( $solicitud->tipo_solicitud == 'Vale' ) {
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
        if ( $solicitud->tipo_solicitud == 'Vale' ) {
            foreach($solicitud->objetivos as $obj){
                $monto_total += $obj->pivot->monto;
            }
        } else {
            foreach($solicitud->rms as $rm){
                $monto_total += $rm->pivot->monto;
            }
        }
        return $monto_total;
    }

}
