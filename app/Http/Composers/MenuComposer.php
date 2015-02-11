<?php namespace Guia\Http\Composers;

use Illuminate\Contracts\View\View;
use Guia\Models\Modulo;

class MenuComposer {

    var $modulos;

    public function __construct(Modulo $modulos)
    {
        $this->modulos = $modulos->orderBy('orden')->get();
    }

    public function compose(View $view)
    {
        $view->with('modulos', $this->modulos);
    }
}