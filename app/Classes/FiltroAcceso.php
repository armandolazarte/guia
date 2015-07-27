<?php

namespace Guia\Classes;


use Guia\Models\Proyecto;

class FiltroAcceso
{

    public $user_id;
    public $presupuesto;

    public function __construct()
    {
        $user = \Auth::user();
        isset($user) ? $this->user_id = $user->id : $this->user_id = 0;

        //Fallback en caso de que no esté implementado middleware 'selPresu' en ruta
        if (!(\Session::has('sel_presupuesto'))) {
            \Session::put('sel_presupuesto', \Carbon\Carbon::now()->year);
        }

        $this->presupuesto = \Session::get('sel_presupuesto');
    }

    public function getArrProyectos()
    {
        $arr_proyectos = array();
        $arr_proyectos = Proyecto::acceso($this->user_id, $this->presupuesto)->get()->lists('proyecto_descripcion', 'id')->all();
        if (count($arr_proyectos) == 0){
            $arr_proyectos[0] = 'No se ha dado de alta el acceso a los proyectos';
        }
        return $arr_proyectos;
    }

    public function getIdsProyectos() {
        $arr_id_proyectos = array();
        $arr_id_proyectos = Proyecto::acceso($this->user_id, $this->presupuesto)->lists('id')->all();

        return $arr_id_proyectos;
    }
}