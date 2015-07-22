<?php namespace Guia\Http\Controllers;

use Guia\Models\AsignaUsuario;
use Guia\Models\Urg;
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
		return view('admin.usuarios.indexUsuario', compact('users'));
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
        $all_request = $request->all();
        $all_request['password'] = bcrypt($all_request['password']);
		$user = User::create($all_request);
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
        $cargos = $user->cargos;
        $urgs = Urg::all();

        //Verifica si el rol del usuario es Administrador
        $user_actual = \Auth::user();
        $arr_roles = $user_actual->roles()->lists('role_name')->all();
        if(array_search('Administrador', $arr_roles) !== false){
            $role_admin = true;
            $usuarios = User::all()->sortBy('nombre')->lists('nombre','id')->all();
        } else {
            $role_admin = false;
            $usuarios = [];
        }

		return view('admin.usuarios.formUsuario')
			->with('user', $user)
			->with('roles', $roles)
            ->with('cargos', $cargos)
            ->with('urgs', $urgs)
            ->with('role_admin', $role_admin)
            ->with('usuarios', $usuarios);
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

        if($request->has('password')) {
            $all_request = $request->all();
            $all_request['password'] = bcrypt($all_request['password']);
        } else {
            $all_request = $request->except(['password', 'password_confirmation']);
        }

		$user->update($all_request);
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
