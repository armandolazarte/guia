<?php namespace Guia\Http\Controllers;

use Guia\User;
use Guia\Models\Role;
use Guia\Http\Requests\UsuarioFormRequest;
use Guia\Http\Controllers\Controller;

//use Illuminate\Http\Request;

class UsuarioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		return view('admin.usuarios.indexUsuario');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$roles = Role::all();
		return view('admin.usuarios.formUsuario', compact('roles'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(UsuarioFormRequest $request)
	{
		$user = User::create($request->all());
		$user->roles()->attach($request->input('role_user'));

		return redirect()->action('UsuarioController@show', array($user->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);
		return view('admin.usuarios.info', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		$roles = Role::all();

		return view('admin.usuarios.formUsuario')
			->with('user', $user)
			->with('roles', $roles);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(UsuarioFormRequest $request, $id)
	{
		$user = User::findOrFail($id);
		$user->update($request->all());
		$user->roles()->sync($request->input('role_user'));

		return redirect()->action('UsuarioController@show', array($user->id));
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
