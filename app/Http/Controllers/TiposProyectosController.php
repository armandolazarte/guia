<?php namespace Guia\Http\Controllers;

use Guia\Models\TipoProyecto;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TiposProyectosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tiposProyecto = TipoProyecto::all();
		return view('admin.tiposProy.index', compact('tiposProyecto'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('admin.tiposProy.formTipoProy');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$tipoProyecto = new TipoProyecto;
		$tipoProyecto->tipo_proyecto = $request->input('tipo_proyecto');
		$tipoProyecto->save();

		return redirect()->action('TiposProyectosController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//@todo Consultar proyectos relacionados con el tipo de proyecto
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipoProyecto = TipoProyecto::find($id);
		return view('admin.tiposProy.formTipoProy', compact('tipoProyecto'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		$tipoProyecto = TipoProyecto::findOrFail($id);
		$tipoProyecto->tipo_proyecto = $request->input('tipo_proyecto');
		$tipoProyecto->save();

		return Redirect::action('TiposProyectosController@index');
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
