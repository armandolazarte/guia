<?php namespace Guia\Http\Controllers;

use Guia\Classes\Pdfs\CuadroPdf;
use Guia\Classes\TerminarCuadro;
use Guia\Http\Requests;
use Guia\Http\Requests\CuadroRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Cotizacion;
use Guia\Models\Cuadro;
use Guia\Models\Oc;
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
                $terminar_cuadro = new TerminarCuadro($cuadro);
                $terminar_cuadro->setMontoArticulo();
                $terminar_cuadro->estatusReq('Cotizada');
                $cuadro->estatus = 'Terminado';

            } elseif ($accion == 'Reanudar') {
                $terminar_cuadro = new TerminarCuadro($cuadro);
                $terminar_cuadro->unsetMontoArticulo();
                $terminar_cuadro->estatusReq('Cotizando');
                $cuadro->estatus = '';
            }
        }
        $cuadro->save();

        return redirect()->action('MatrizCuadroController@show', array($cuadro->req_id));
        /**
         * @todo Actualizar estatus de requisición a cotizada
         */
	}

	/**
	 * Elimina cuadro comparativo, cotizaciones y relación articulo_cotizacion
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$cuadro = Cuadro::findOrFail($id);
        $req_id = $cuadro->req_id;
        $cotizaciones = Cotizacion::whereReqId($cuadro->req_id)->with('articulos')->get();
        foreach($cotizaciones as $cotizacion) {
            $cotizacion->articulos()->detach();
            $cotizacion->delete();
        }

        /**
         * @todo Enviar correo a Jefe de la Unidad de Presupuesto
         * @todo Eliminar archivos cargados
         */
        $ocs = Oc::whereReqId($req_id)->lists('id');
        if(count($ocs) > 0) {
            Articulo::whereIn('oc_id', $ocs)->update(['oc_id' => 0]);
            foreach($ocs as $oc_id) {
                $oc = Oc::find($oc_id)->delete();
            }
        }

        $cuadro->delete();

        return redirect()->action('RequisicionController@show', array($req_id))
            ->with(['message' => 'Cuadro Comparativo cancelado con éxito', 'alert-class' => 'alert-success']);
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
