<?php

namespace Guia\Http\Controllers;

use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class UsuarioAsignadoController extends Controller
{
    public function loginAsignado($id, Request $request)
    {
        /**
         * @todo Verificar que el usuario tenga asignada la cuenta de usuario
         */

        if($request->session()->has('usuarioOriginal')) {
            $request->session()->forget('usuarioOriginal');
        } else {
            $usaurio_original_id = \Auth::user()->id;
            $request->session()->put('usuarioOriginal', $usaurio_original_id);
        }

        \Auth::loginUsingId($id);

        return redirect()->back();
    }

}
