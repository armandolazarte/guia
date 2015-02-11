<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Models\Modulo;
use Guia\Models\Role;

use Illuminate\Http\Request;

class ModuloController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$modulos = Modulo::with('roles')->get();
		$data['modulos'] = $modulos;
		return view('admin.su.modulos.indexModulo', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Role::all();
		return view('admin.su.modulos.formModulo', compact('roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$modulo = new Modulo;
		$modulo->ruta = \Input::get('ruta');
		$modulo->nombre = \Input::get('nombre');
		$modulo->icono = \Input::get('icono');
		$modulo->orden = \Input::get('orden');
		$modulo->activo = \Input::get('activo');
		$modulo->save();

		//Asociar con Roles
		if( count(\Input::get('modulo_role')) > 0 ){
			$modulo_role = \Input::get('modulo_role');
			$modulo->roles()->sync($modulo_role);
		}

		return redirect()->action('ModuloController@index');
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
		$modulo = Modulo::find($id);
		$roles = Role::all();

		return view('admin.su.modulos.formModulo')
			->with('modulo', $modulo)
			->with('roles', $roles);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$modulo = Modulo::findOrFail($id);
		$modulo->ruta = \Input::get('ruta');
		$modulo->nombre = \Input::get('nombre');
		$modulo->icono = \Input::get('icono');
		$modulo->orden = \Input::get('orden');
		$modulo->activo = \Input::get('activo');
		$modulo->save();

		//Asociar con Roles
		if( count(\Input::get('modulo_role')) > 0 ){
			$modulo_role = \Input::get('modulo_role');
			$modulo->roles()->sync($modulo_role);
		}

		return redirect()->action('ModuloController@index');
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
