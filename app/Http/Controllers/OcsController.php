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
        $oc = Oc::find($id);
        $oc->load('articulos');

        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        if (array_search('Cotizador', $arr_roles) !== false || array_search('Adquisiciones', $arr_roles) !== false) {
            $acciones_suministros = true;
        } else {
            $acciones_suministros = false;
        }

        $archivos = $oc->archivos()->get();
        if(count($archivos) == 0) {
            $archivos = array();
        }

        return view('oc.infoOc', compact('oc','archivos','acciones_suministros'));
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
		$oc = Oc::findOrFail($id);
        /**
         * @todo Enviar correo a Jefe de la Unidad de Presupuesto
         * @todo Eliminar archivos cargados
         */
        Articulo::where('oc_id', '=', $id)
            ->update(['oc_id' => 0]);
        $req_id = $oc->req_id;
		$oc->delete();

        return redirect()->action('OcsController@index', $req_id)
            ->with(['message' => 'Orden de Compra cancelada con éxito', 'alert-class' => 'alert-success']);
	}

    public function ordenCompraPdf($id)
    {
        $oc = Oc::find($id);
        $oc->load('articulos');
        $oc_pdf = new OrdenCompraPdf($oc);

        return response($oc_pdf->crearPdf())->header('Content-Type', 'application/pdf');
    }

}
