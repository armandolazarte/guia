<?php namespace Guia\Classes;

use Guia\Models\Proyecto;

class FiltroAcceso {

    var $arr_proyectos;
    var $user_id;

    public function __construct()
    {
        $user = \Auth::user();
        isset($user) ? $this->user_id = $user->id : $this->user_id = 0;
    }

    public function consultarProyectos()
    {
        $presupuesto = \Session::get('sel_presupuesto');
        $this->arr_proyectos = array();
        $this->arr_proyectos = Proyecto::acceso($this->user_id, $presupuesto)->get()->lists('proyecto_descripcion', 'id')->all();
    }

    public function getArrProyectos()
    {
        $this->consultarProyectos();
        if (count($this->arr_proyectos) == 0){
            $this->arr_proyectos[0] = 'No se ha dado de alta el acceso a los proyectos';
        }
        return $this->arr_proyectos;
    }
}