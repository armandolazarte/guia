<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Cargo;
use Illuminate\Http\Request;

class CargosController extends Controller
{
    public function store(Request $request)
    {
        $cargo = new Cargo();
        $cargo->user_id = $request->input('user_id');
        $cargo->cargo = $request->input('cargo');
        $cargo->inicio = $request->input('inicio');
        $cargo->fin = $request->input('fin');
        $cargo->save();

        $cargo->urgs()->attach($request->input('cargo_urg'));

        return redirect()->action('UsuarioController@show', array($request->input('user_id')));
    }

    public function update($id)
    {
        //@todo Actualizar información de un cargo
    }

}
