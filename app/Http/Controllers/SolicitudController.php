<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\FiltroEstatusResponsable;
use Guia\Classes\FirmasSolRec;
use Guia\Classes\Pdfs\SolicitudPdf;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Http\Requests\SolicitudFormRequest;
use Guia\Models\Archivos\Archivo;
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
	public function index($scope = null)
	{
        if ($scope == 'presupuesto') {
            $filtro = new FiltroEstatusResponsable();
            $filtro->filtroSolicitudes();
            $solicitudes = Solicitud::estatusResponsable($filtro->arr_estatus, $filtro->arr_responsable)->orderBy('id', 'DESC')->get();
        } else {
            $solicitudes = Solicitud::MisSolicitudes()->orderBy('id', 'DESC')->get();
        }

        $solicitudes->load('urg');
        $solicitudes->load('benef');
        return view('solicitudes.indexSolicitud', compact('solicitudes'));
	}

	/**
	 * Formulario para captura de una solicitud
	 *
	 * @return Response
	 */
	public function create()
	{
        $arr_urgs = Urg::where('urg', 'LIKE', '%.%')->get()->lists('urg_desc', 'id')->all();

        $arr_tipos_solicitud['Reposicion'] = 'Reposicion (Reembolso)';
        $arr_tipos_solicitud['Recibo'] = 'Recibo (Pago a Proveedor)';
        $arr_tipos_solicitud['Vale'] = 'Vale (Gasto por Comprobar)';

        $benefs = Benef::all(array('id','benef'));
        $benefs = $benefs->sortBy('benef');
        foreach($benefs as $benef){
            $arr_benefs[$benef->id] = $benef->benef;
        }
        $arr_proyectos = \FiltroAcceso::getArrProyectos();
        $vobos = FirmasSolRec::getUsersVoBo();
        $arr_vobo[0] = 'Sin Vo. Bo.';
        foreach($vobos as $vobo){
            $arr_vobo[$vobo->id] = $vobo->nombre.' - '.$vobo->cargo;
        }
        return view('solicitudes.formSolicitud')
            ->with('urgs', $arr_urgs)
            ->with('tipos_solicitud', $arr_tipos_solicitud)
            ->with('proyectos', $arr_proyectos)
            ->with('benefs', $arr_benefs)
            ->with('arr_vobo', $arr_vobo);
	}

	/**
	 * Guarda información de solicitud
	 *
	 * @return Response
	 */
	public function store(SolicitudFormRequest $request)
	{
        $request->merge(array(
            'solicita' => \Auth::user()->id,
            'fecha' => Carbon::now()->toDateString()
        ));

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
        $arr_roles = array();
        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();

        //Determina Acciones Unidad de Presupuesto
        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false || array_search('Contabilidad', $arr_roles) !== false){
            $acciones_presu = true;
        } else {
            $acciones_presu = false;
        }

        $solicitud = Solicitud::find($id);

        $archivos = $solicitud->archivos()->get();
        if(count($archivos) == 0) {
            $archivos = array();
        }
        $archivos_relacionados = [];

        return view('solicitudes.infoSolicitud', compact('solicitud', 'acciones_presu', 'archivos','archivos_relacionados', 'arr_roles'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $sol = Solicitud::findOrFail($id);

        $arr_tipos_solicitud['Reposicion'] = 'Reposicion (Reembolso)';
        $arr_tipos_solicitud['Recibo'] = 'Recibo (Pago a Proveedor)';
        $arr_tipos_solicitud['Vale'] = 'Vale (Gasto por Comprobar)';

        $urgs = Urg::all(array('id','urg','d_urg'));
        foreach($urgs as $urg){
            $arr_urgs[$urg->id] = $urg->urg.' - '.$urg->d_urg;
        }
        $benefs = Benef::all(array('id','benef'));
        $benefs = $benefs->sortBy('benef');
        foreach($benefs as $benef){
            $arr_benefs[$benef->id] = $benef->benef;
        }
        $arr_proyectos = \FiltroAcceso::getArrProyectos();
        $vobos = FirmasSolRec::getUsersVoBo();
        $arr_vobo[0] = 'Sin Vo. Bo.';
        foreach($vobos as $vobo){
            $arr_vobo[$vobo->id] = $vobo->nombre.' - '.$vobo->cargo;
        }

        return view('solicitudes.formSolicitud')
            ->with('sol', $sol)
            ->with('tipos_solicitud', $arr_tipos_solicitud)
            ->with('urgs', $arr_urgs)
            ->with('proyectos', $arr_proyectos)
            ->with('benefs', $arr_benefs)
            ->with('arr_vobo', $arr_vobo);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, SolicitudFormRequest $request)
	{
		$solicitud = Solicitud::findOrFail($id);

        //Actualización de estatus
        $accion = $request->input('accion');
        if(isset($accion)){

            if($accion == 'Enviar') {
                $estatus = 'Enviada';
            } elseif($accion == 'Recuperar'){
                $estatus = '';
            } elseif($accion == 'Autorizar'){
                $estatus = 'Autorizada';
            } elseif($accion == 'Desautorizar'){
                $estatus = 'Recibida';
            }

            $solicitud->estatus = $estatus;
            $solicitud->save();

            //Creación de registro
            $fecha_hora = Carbon::now();
            $registro = new Registro(['user_id' => Auth::user()->id, 'estatus' => $estatus, 'fecha_hora' => $fecha_hora]);
            $solicitud->registros()->save($registro);

        } else {
            $solicitud->tipo_solicitud = $request->input('tipo_solicitud');
            $solicitud->proyecto_id = $request->input('proyecto_id');

            $solicitud->urg_id = $request->input('urg_id');
            $solicitud->benef_id = $request->input('benef_id');
            $solicitud->no_documento = $request->input('no_documento');
            $solicitud->concepto = $request->input('concepto');
            $solicitud->obs = $request->input('obs');
            $solicitud->autoriza = FirmasSolRec::getUserAutoriza($request->input('proyecto_id'));
            $solicitud->viaticos = $request->input('viaticos');
            $solicitud->vobo = $request->input('vobo');
            $solicitud->save();
        }

        return redirect()->action('SolicitudController@show', array($solicitud->id));
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
        return response($solicitud_pdf->crearPdf()->header('Content-Type', 'application/pdf'));
    }
}
