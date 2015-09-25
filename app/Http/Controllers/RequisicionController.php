<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\ArticulosHelper;
use Guia\Classes\FiltroEstatusResponsable;
use Guia\Models\Cotizacion;
use Guia\Models\Cuadro;
use Guia\Models\Oc;
use Guia\Models\Req;
use Guia\Models\Urg;
use Guia\Models\Articulo;
use Guia\Models\Registro;
use Guia\Classes\FirmasSolRec;
use Guia\Http\Requests\ReqFormRequest;
use Guia\Http\Requests;
use Guia\Classes\Pdfs\Requisicion;
use Guia\Http\Controllers\Controller;

use Guia\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequisicionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($scope = null)
	{
        if ($scope == 'suministros' || $scope == 'presupuesto') {
            $filtro = new FiltroEstatusResponsable();
            $filtro->filtroReqs();
            $reqs = Req::estatusResponsable($filtro->arr_estatus, $filtro->arr_responsable)->orderBy('req', 'DESC')->get();
        } elseif ($scope == 'seguimiento') {
            $reqs = Req::seguimiento()->get();
        } else {
            $reqs = Req::misReqs()->orderBy('req', 'DESC')->get();
        }

		$reqs->load('proyecto.urg');
        $reqs->load('proyecto.fondos');
        $reqs->load('user');
		return view('reqs.indexReq', compact('reqs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$urgs = Urg::where('urg', 'LIKE', '%.%')->get(array('id','urg','d_urg'));

		$arr_proyectos = \FiltroAcceso::getArrProyectos();
        $arr_vobo = FirmasSolRec::getUsersVoBo();
		return view('reqs.formRequisicion')
			->with('urgs', $urgs)
			->with('proyectos', $arr_proyectos)
            ->with('arr_vobo', $arr_vobo);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ReqFormRequest $request)
	{
		//$data = Input::all();
		$data = $request->all();

		$req = new Req();
		$req->req = \Consecutivo::nextReq();
		$req->fecha_req = Carbon::now()->toDateString();
		$req->urg_id = $request->input('urg_id');
		$req->proyecto_id = $request->input('proyecto_id');
		$req->etiqueta = $request->input('etiqueta');
		$req->lugar_entrega = $request->input('lugar_entrega');
		$req->obs = $request->input('obs');
		$req->solicita = \Auth::user()->id;
		$req->autoriza = FirmasSolRec::getUserAutoriza($request->input('proyecto_id'));
		$req->vobo = $request->input('vobo');
		$req->estatus = "";
		$req->tipo_orden = "Compra";
		$req->save();

		return redirect()->action('RequisicionController@show', array($req->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$req = Req::find($id);
        $articulos = Articulo::whereReqId($id)->with('cotizaciones')->with('rms.cog')->get();
		$data['req'] = $req;

        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        $data['arr_roles'] = $arr_roles;

        if(array_search('Cotizador', $arr_roles) !== false || array_search('Adquisiciones', $arr_roles) !== false){

            $usuarios_suministros = User::whereHas('roles', function($query) {
                $query->whereIn('role_id', [4,5]);
            })->where('id', '!=', Auth::user()->id)->orderBy('nombre')->lists('nombre', 'id')->all();
            $data['usuarios_suministros'] = $usuarios_suministros;

            $data['acciones_suministros'] = true;
        } else {
            $data['acciones_suministros'] = false;
        }

        if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false){
            $data['acciones_presu'] = true;
        } else {
            $data['acciones_presu'] = false;
        }

		if (isset($articulos)) {
			$data['articulos'] = $articulos;
		} else {
			$data['articulos'] = array();
		}

        $articulos_helper = new ArticulosHelper($articulos, $id);
        $articulos_helper->setRmsArticulos();
        $data['rms_articulos'] = $articulos_helper->rms_articulos;

        $solicita = User::find($req->solicita);
        $data['solicita'] = $solicita;

		return view('reqs.infoRequisicion')->with($data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $req = Req::findOrFail($id);

        $urgs = Urg::all(array('id','urg','d_urg'));
        $arr_proyectos = \FiltroAcceso::getArrProyectos();
        $arr_vobo = FirmasSolRec::getUsersVoBo();

        return view('reqs.formRequisicion')
            ->with('req', $req)
            ->with('urgs', $urgs)
            ->with('proyectos', $arr_proyectos)
            ->with('arr_vobo', $arr_vobo);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ReqFormRequest $request)
	{
		$req = Req::findOrFail($id);

        //Actualización de estatus
        $accion = $request->input('accion');
        if(isset($accion)){

            switch($accion) {
                case 'Enviar'       : $estatus = 'Enviada'; break;
                case 'Recuperar'    :
                case 'Regresar'     : $estatus = ''; break;
                case 'Autorizar'    : $estatus = 'Autorizada'; break;
                case 'Desautorizar' : $estatus = 'Cotizada'; break;
            }

            if($accion == 'Asignar') {
                $user_id_responsable = $request->input('user_id');
                if (empty($user_id_responsable)) {
                    return redirect()->action('RequisicionController@show', array($req->id))->with(['message' => 'No se seleccionó ningún usuario a asignar']);
                }
                $estatus = 'Asignada';//Solo para efectos del registro
                $req->user_id = $user_id_responsable;
                $nombre = User::whereId($user_id_responsable)->pluck('nombre');
                $mensaje_exito = 'La requisición '.$req->req.' ha sido asignada a '.$nombre;
            } elseif ($accion == 'Desautorizar') {
                $articulos = Articulo::whereReqId($id)->get();
                foreach($articulos as $articulo){
                    if($articulo->rms->count() > 0){
                        foreach ($articulo->rms as $articulo_rm) {
                            $articulo->rms()->updateExistingPivot($articulo_rm->id, ['rm_id' => 0, 'monto' => 0]);
                        }
                    }
                }
                $req->estatus = $estatus;
            } else {
                $req->estatus = $estatus;
            }

            $req->save();

            if($accion == 'Regresar') {
                $cuadro = Cuadro::whereReqId($id)->first();
                if(!empty($cuadro)) {
                    $cuadro->delete();
                }
                $cotizaciones = Cotizacion::whereReqId($id)->with('articulos')->get();
                if(count($cotizaciones) > 0) {
                    foreach($cotizaciones as $cotizacion) {
                        $cotizacion->articulos()->detach();
                        $cotizacion->delete();
                    }
                }

                /**
                 * @todo Enviar correo a Jefe de la Unidad de Presupuesto
                 * @todo Eliminar archivos cargados
                 */
                $ocs = Oc::whereReqId($id)->lists('id');
                if(count($ocs) > 0) {
                    Articulo::whereIn('oc_id', $ocs)->update(['oc_id' => 0]);
                    foreach($ocs as $oc_id) {
                        Oc::find($oc_id)->delete();
                    }
                }
                $mensaje_exito = 'La requisición ha sido regresada con éxito';
            }

            //Creación de registro
            $fecha_hora = Carbon::now();
            $registro = new Registro(['user_id' => Auth::user()->id, 'estatus' => $estatus, 'fecha_hora' => $fecha_hora]);
            $req->registros()->save($registro);

        //Edición de información
        } else {
            $req->urg_id = $request->input('urg_id');
            $req->proyecto_id = $request->input('proyecto_id');
            $req->etiqueta = $request->input('etiqueta');
            $req->lugar_entrega = $request->input('lugar_entrega');
            $req->obs = $request->input('obs');
            $req->autoriza = FirmasSolRec::getUserAutoriza($request->input('proyecto_id'));
            $req->vobo = $request->input('vobo');
            $req->save();
        }

        if($accion == 'Regresar' || $accion == 'Asignar') {
            return redirect()->action('RequisicionController@index', 'suministros')
                ->with(['message' => $mensaje_exito, 'alert-class' => 'alert-success']);
        }
        return redirect()->action('RequisicionController@show', array($req->id));
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
        $req = Req::find($id);
        $articulos = Articulo::whereReqId($id)->get();
        $req_pdf = new Requisicion($req, $articulos);
        return response($req_pdf->crearPdf()->header('Content-Type', 'application/pdf'));
    }

}
