<?php namespace Guia\Http\Controllers;

use Guia\Classes\Pdfs\CuadroPdf;
use Guia\Http\Requests;
use Guia\Http\Requests\CuadroRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Cuadro;
use Illuminate\Http\Request;

class CuadroController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
	public function store()
	{
		//
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
	public function update($id, CuadroRequest $request)
	{
		$cuadro = Cuadro::findOrFail($id);

        //Actualización de estatus
        $accion = $request->input('accion');
        if(isset($accion)) {
            if ($accion == 'Terminar') {
                $estatus = 'Terminada';
            } elseif ($accion == 'Reanudar') {
                $estatus = '';
            }
        }
        $cuadro->estatus = $estatus;
        $cuadro->save();

        /**
         * @todo Actualizar estatus de requisición a cotizada
         */
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

    public function cuadroPdf($id)
    {
        $cuadro = Cuadro::find($id);
        $cuadro->load('cotizaciones');

        $articulos = Articulo::whereReqId($cuadro->req_id)->get();
        $articulos->load('cotizaciones');

        $cuadro_pdf = new CuadroPdf($cuadro, $articulos);

        return response($cuadro_pdf->crearPdf())->header('Content-Type', 'application/pdf');
    }

}
