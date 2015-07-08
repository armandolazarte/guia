<?php

namespace Guia\Http\Composers;


use Guia\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;


class UsuariosAsignadosComposer
{

    public $usuarios_asignados;

    public function __construct(Request $request)
    {
        if(\Auth::check()) {
            $usuarios_asignados = \Auth::user()->usuariosAsignados()->get();
            if(count($usuarios_asignados) > 0) {
                foreach($usuarios_asignados as $usuario_asignado) {
                    $this->usuarios_asignados[] = $usuario_asignado->usuarioAsigna()->first(['id', 'nombre']);
                }
            }
            if($request->session()->has('usuarioOriginal')) {
                $usuario_original = User::find($request->session()->get('usuarioOriginal'));
                $this->usuarios_asignados[] = $usuario_original;
            }
        }
    }

    public function compose(View $view)
    {
        $view->with('usuarios_asignados', $this->usuarios_asignados);
    }

}
