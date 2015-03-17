<?php namespace Guia\Http\Composers;

use Guia\User;
use Illuminate\Contracts\View\View;
use Guia\Models\Modulo;
use Illuminate\Support\Collection;

class MenuComposer {

    public $modulos;

    public function __construct(Modulo $modulos)
    {
        if(\Auth::check()) {
            $user = User::find(\Auth::user()->id);
            if (count($user->roles) > 0){
                $modulos = new Collection();
                foreach ($user->roles as $role) {
                    $modulos = $modulos->merge($role->modulos()->orderBy('orden')->get());
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