<?php namespace Guia\Classes;

use Guia\Models\Proyecto;

class FiltroAcceso {

    var $proyectos;
    var $user_id;

    public function __construct()
    {
        $user = \Auth::user();
        //dd($user->id);
        isset($user) ? $this->user_id = $user->id : $this->user_id = 0;
    }

    public function consultarProyectos()
    {
        //@todo Determinar a partir de formulario
        if(empty($presupuesto)){
            $presupuesto = \Carbon\Carbon::now()->year;
        }
        $this->proyectos = Proyecto::acceso($this->user_id, $presupuesto)->get(array('id','proyecto','d_proyecto'));
    }

    public function getArrProyectos()
    {
        $this->consultarProyectos();

        $arr_proyectos = array();
        if (count($this->proyectos) > 0){
            foreach($this->proyectos as $proyecto){
                $arr_proyectos[$proyecto->id] = $proyecto->proyecto.' - '.$proyecto->d_proyecto;
            }
        } else {
            $arr_proyectos[0] = 'No se ha dado de alta el acceso a los proyectos';
        }
        return $arr_proyectos;
    }
}