<?php namespace Guia\Http\Composers;

use Guia\User;
use Illuminate\Contracts\View\View;
use Guia\Models\Modulo;

class MenuComposer {

    var $modulos;

    public function __construct(Modulo $modulos)
    {
        $user = User::find(\Auth::user()->id);
        foreach($user->roles as $role){
            $modulos = $role->modulos()->orderBy('orden')->get();
        }
        $this->modulos = $modulos;
    }

    public function compose(View $view)
    {
        $view->with('modulos', $this->modulos);
    }
}