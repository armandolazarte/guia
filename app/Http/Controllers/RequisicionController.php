<?php namespace Guia\Http\Controllers;

use Guia\Models\Req;
use Guia\Models\Urg;
use Guia\Models\Articulo;
use Guia\Classes\FirmasSolRec;
use Guia\Http\Requests\ReqFormRequest;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RequisicionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$reqs = Req::whereSolicita(\Auth::user()->id)->get();
		$reqs->load('urg');
		return view('reqs.indexReq', compact('reqs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$urgs = Urg::all(array('id','urg','d_urg'));
		$arr_proyectos = \FiltroAcceso::getArrProyectos();
		return view('reqs.formRequisicion')
			->with('urgs', $urgs)
			->with('proyectos', $arr_proyectos);
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
		$req->fecha_req = \Carbon\Carbon::now()->toDateString();
		$req->urg_id = $request->input('urg_id');
		$req->proyecto_id = $request->input('proyecto_id');
		$req->etiqueta = $request->input('etiqueta');
		$req->lugar_entrega = $request->input('lugar_entrega');
		$req->obs = $request->input('obs');
		$req->solicita = \Auth::user()->id;
		$req->autoriza = FirmasSolRec::getUserAutoriza($request->input('proyecto_id'));
		//$req->vobo = ;
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
		$articulos = Articulo::whereReqId($id)->get();
		$data['req'] = $req;
		if (isset($articulos)) {
			$data['articulos'] = $articulos;
		} else {
			$data['articulos'] = array();
		}
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}
