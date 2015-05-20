<?php namespace Guia\Http\Controllers;

use Guia\Classes\Pdfs\OrdenCompraPdf;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Oc;
use Guia\Models\OcsCondicion;
use Illuminate\Http\Request;

class OcsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($req_id)
	{
		$ocs = Oc::whereReqId($req_id)->with('benef')->get();

        return view('oc.indexOcs', compact('ocs','req_id'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($req_id)
	{
        $generador_ocs = new \Guia\Classes\GeneradorOcs($req_id);
        $generador_ocs->genera_oc();

        return redirect()->action('OcsController@index', array($req_id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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

    public function ordenCompraPdf($id)
    {
        $oc = Oc::find($id);
        $oc->load('articulos');
        $oc_pdf = new OrdenCompraPdf($oc);

        return response($oc_pdf->crearPdf())->header('Content-Type', 'application/pdf');
    }

}
