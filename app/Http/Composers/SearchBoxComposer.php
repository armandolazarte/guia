<?php

namespace Guia\Http\Composers;


use Illuminate\Contracts\View\View;

class SearchBoxComposer
{
    public $search_box;

    public function __construct()
    {
        if(\Auth::check()) {
            $user = \Auth::user();
            $arr_roles = $user->roles()->lists('role_name')->all();
            if(array_search('Ejecutora', $arr_roles) !== false || array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false || array_search('Contabilidad', $arr_roles) !== false){
                $this->search_box = true;
            } else {
                $this->search_box = false;
            }
        } else {
            $this->search_box = false;
        }
    }

    public function compose(View $view)
    {
        $view->with('search_box', $this->search_box);
    }
}