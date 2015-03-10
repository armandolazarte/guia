<?php namespace Guia\Http\Composers;

use Guia\User;
use Illuminate\Contracts\View\View;
use Guia\Models\Modulo;

class MenuComposer {

    var $modulos;

    public function __construct(Modulo $modulos)
    {
        if(\Auth::check()) {
            $user = User::find(\Auth::user()->id);
            if (count($user->roles) > 0){
                foreach ($user->roles as $role) {
                    $modulos = $role->modulos()->orderBy('orden')->get();
                }
                $this->modulos = $modulos;
            } else {
                $this->modulos = null;
            }
        }
    }

    public function compose(View $view)
    {
        $view->with('modulos', $this->modulos);
    }
}