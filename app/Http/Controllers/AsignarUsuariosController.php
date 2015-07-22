<?php

namespace Guia\Http\Controllers;

use Guia\Models\AsignaUsuario;
use Guia\User;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class AsignarUsuariosController extends Controller
{
    /**
     * Muestra los usuarios asignados para manejar la cuenta de usuario
     *
     * @return Response
     */
    public function index($user_id)
    {
        //
    }

    /**
     * Muestra formulario para asignar derechos para manejar la cuenta a un usuario
     *
     * @return Response
     */
    public function create($user_id)
    {
        //$usuarios = User::all()->sortBy('nombre')->lists('nombre','id')->all();
        //return view('admin.usuarios.asignaUsuario.formAsignar', compact('usuarios','user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        AsignaUsuario::create($request->all());

        return redirect()->action('UsuarioController@show', $request->input('user_id'))->with(['message' => 'Usuario Asignado con Exito']);
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
}
