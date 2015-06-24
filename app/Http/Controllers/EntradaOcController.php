<?php namespace Guia\Http\Controllers;

use Guia\Classes\Pdfs\EntradaSalidaPdf;
use Guia\Http\Requests;
use Guia\Http\Requests\EntradaOcRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\Almacen\Entrada;
use Guia\Models\Articulo;
use Guia\Models\Oc;
use Guia\Models\Urg;
use Illuminate\Http\Request;

class EntradaOcController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //Listar Ocs
        $ocs = Oc::all();

        return view('almacen.entrada.indexEntradaOc', compact('ocs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($oc)
	{
		$oc = Oc::whereOc($oc)->get();
        $articulos = Articulo::whereOcId($oc[0]->id)->get();
        $urgs = Urg::all(array('id','urg','d_urg'));

        return view('almacen.entrada.formArticulosOc', compact('oc', 'articulos', 'urgs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EntradaOcRequest $request)
	{
		//Crear Entrada
        $entrada = new Entrada();
        $entrada->fecha_entrada = \Carbon\Carbon::now()->toDateString();;
        $entrada->ref = $request->input('oc');
        $entrada->ref_tipo = 'OC';
        $entrada->ref_fecha = $request->input('fecha_oc');
        $entrada->urg_id = $request->input('urg_id');
        $entrada->benef_id = $request->input('benef_id');
        $entrada->cmt = $request->input('cmt');
        $entrada->responsable = \Auth::user()->id;
        $entrada->save();

        //Crear articulo_entrada
        foreach($request->input('arr_articulo_id') as $art){
            $cantidad = $request->input('cantidad_'.$art);
            if($cantidad > 0){
                $entrada->articulos()->attach($art, ['cantidad' => $cantidad]);
            }
        }

        /**
         * @todo Redirect a Info de Entrada
         */
        return redirect()->action('EntradaOcController@index');
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

    public function formatoPdf($id)
    {
        $entrada = Entrada::find($id);
        $entrada->load('articulos');
        if ($entrada->ref_tipo == 'OC') {
            $oc = Oc::whereOc($entrada->ref)->get();
        }

        $data['tipo_formato'] = 'Entrada';
        $data['req'] = $oc[0]->req->req;
        $data['ref_tipo'] = $entrada->ref_tipo;
        $data['ref'] = $entrada->ref;
        $data['fecha_oc'] = $oc[0]->fecha_oc;
        $data['d_proveedor'] = $entrada->benef->benef;
        $data['id'] = $id;
        $data['fecha'] = $entrada->fecha_entrada;
        $data['d_urg'] = $entrada->urg->d_urg;
        $data['cmt'] = $entrada->cmt;
        $data['usr_id'] = $entrada->usr_id;

        $entrada_pdf = new EntradaSalidaPdf($data);

        return response($entrada_pdf->crearEntradaPdf($entrada))
            ->header('Content-Type', 'application/pdf');
    }

}
