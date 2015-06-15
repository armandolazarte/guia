<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Req;
use Illuminate\Http\Request;

class AutorizarReqController extends Controller {

	/**
	 * Muestra formulario para autorizar requisición.
	 *
	 * @return Response
	 */
	public function formAutorizar($id)
	{
        $req = Req::find($id);
        $req->fecha_req = Carbon::parse($req->fecha_req)->format('d/m/Y');
        $articulos = Articulo::whereReqId($id)->get();
        $articulos->load('cotizaciones');

        $data['req'] = $req;
        $data['articulos'] = $articulos;

        return view('reqs.formAutorizarReq')->with($data);
	}

	/**
	 * Actualiza información con la autorización.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function autorizar($id)
	{
		//
	}

	/**
	 * Desautoriza una requisición.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function desautorizar($id)
	{
		//
	}

}
