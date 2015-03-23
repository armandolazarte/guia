<?php namespace Guia\Http\Controllers;

use Guia\Models\Req;
use Guia\Models\Unidad;
use Guia\Models\Articulo;
use Guia\Http\Requests;
use Guia\Http\Requests\ArticuloFormRequest;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ArticulosController extends Controller {

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
	public function create($req_id)
	{
		$req = Req::find($req_id);
		$unidades = Unidad::all();
		$data['req'] = $req;

		foreach($unidades as $unidad){
			$arr_unidades[$unidad->tipo][$unidad->unidad] = $unidad->unidad;
		}
		$data['unidades'] = $arr_unidades;

		return view('reqs.formArticulo')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ArticuloFormRequest $request)
	{
		$articulo = new Articulo();
		$articulo->req_id = $request->input('req_id');
		$articulo->articulo = $request->input('articulo');
		$articulo->cantidad = $request->input('cantidad');
		$articulo->unidad = $request->input('unidad');
		$articulo->save();

		return redirect()->action('RequisicionController@show', array($request->input('req_id')));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
     * @param  int  $req_id
	 * @param  int  $articulo_id
	 * @return Response
	 */
	public function edit($req_id, $articulo_id)
	{
		$articulo = Articulo::find($articulo_id);

		//Verifica que el artículo corresponda a la requisición
		if ($articulo->req_id == $req_id)
		{
			$unidades = Unidad::all();
			foreach($unidades as $unidad){
				$arr_unidades[$unidad->tipo][$unidad->unidad] = $unidad->unidad;
			}

			$data['articulo'] = $articulo;
			$data['req'] = $articulo->req;
			$data['unidades'] = $arr_unidades;

			return view('reqs.formArticulo')->with($data);
		} else {
			return redirect()->action('RequisicionController@show', array($req_id))->with(['alert-class' => 'alert-warning', 'message' => 'El artículo no corresponde a la requisición']);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ArticuloFormRequest $request, $id)
	{
		$rules = array(
			'articulo' => 'required',
			'cantidad' => 'required|numeric',
			'unidad' => 'required'
		);

		$articulo = Articulo::findOrFail($id);
		$articulo->articulo = $request->input('articulo');
		$articulo->cantidad = $request->input('cantidad');
		$articulo->unidad =$request->input('unidad');
		$articulo->save();

		return redirect()->action('RequisicionController@show', array($articulo->req->id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$articulo = Articulo::findOrFail($id);
		$req_id = $articulo->req->id;
		$articulo->delete();
		return redirect()->action('RequisicionController@show', array($req_id));
	}

}
