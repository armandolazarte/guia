<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\FirmasSolRec;
use Guia\Classes\Pdfs\SolicitudPdf;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Http\Requests\SolicitudFormRequest;
use Guia\Models\Solicitud;
use Guia\Models\Urg;
use Guia\Models\Benef;
use Guia\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller {

	/**
	 * Lista las solicitudes capturadas por el usuario
	 *
	 * @return Response
	 */
	public function index()
	{
		$solicitudes = Solicitud::whereSolicita(\Auth::user()->id)->get();
        $solicitudes->load('urg');
        return view('solicitudes.indexSolicitud', compact('solicitudes'));
	}

	/**
	 * Formulario para captura de una solicitud
	 *
	 * @return Response
	 */
	public function create()
	{
        $urgs = Urg::all(array('id','urg','d_urg'));
        $benefs = Benef::all(array('id','benef'));
        $arr_proyectos = \FiltroAcceso::getArrProyectos();
        $arr_vobo = FirmasSolRec::getUsersVoBo();
        return view('solicitudes.formSolicitud')
            ->with('urgs', $urgs)
            ->with('proyectos', $arr_proyectos)
            ->with('benefs', $benefs)
            ->with('arr_vobo', $arr_vobo);
	}

	/**
	 * Guarda información de solicitud
	 *
	 * @return Response
	 */
	public function store(SolicitudFormRequest $request)
	{
        $request->merge(array('solicita' => \Auth::user()->id));

        $autoriza = FirmasSolRec::getUserAutoriza($request->input('proyecto_id'));
        $request->merge(array('autoriza' => $autoriza));

        $solicitud = Solicitud::create($request->all());
        return redirect()->action('SolicitudController@show', array($solicitud->id));
	}

	/**
	 * Muestra la información de una solicitud
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $solicitud = Solicitud::find($id);
        return view('solicitudes.infoSolicitud', compact('solicitud'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$solicitud = Solicitud::findOrFail($id);

        //Actualización de estatus
        $accion = $request->input('accion');
        if(isset($accion)){

            if($accion == 'Enviar') {
                $estatus = 'Enviada';
            } elseif($accion == 'Recuperar'){
                $estatus = '';
            }

            $solicitud->estatus = $estatus;
            $solicitud->save();

            //Creación de registro
            $fecha_hora = Carbon::now();
            $registro = new Registro(['user_id' => Auth::user()->id, 'estatus' => $estatus, 'fecha_hora' => $fecha_hora]);
            $solicitud->registros()->save($registro);

            return redirect()->action('SolicitudController@show', array($solicitud->id));
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function formatoPdf($id)
    {
        $solicitud = Solicitud::find($id);
        $solicitud_pdf = new SolicitudPdf($solicitud);
        return view($solicitud_pdf->crearPdf());
    }
}
