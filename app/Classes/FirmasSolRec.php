<?php

namespace Guia\Classes;


use Guia\Models\Cargo;
use Guia\Models\Proyecto;
use Guia\Models\Urg;

class FirmasSolRec
{
    public static function getUserAutoriza($proyecto_id)
    {
        $urg_id = Proyecto::find($proyecto_id)->urg_id;
        $urg = Urg::find($urg_id);
        $cargos = $urg->cargos()->where('fin', '=', '0000-00-00')->get(array('user_id'));
        if (count($cargos) > 0){
            $user_id = $cargos[0]->user_id;
        } else {
            $user_id = 0;
        }
        return $user_id;
    }

    public static function getUsersVoBo()
    {
        $arr_users = array();
        $cargos = Cargo::with('user')->get();
        foreach($cargos as $cargo){
            $arr_users[] = $cargo->user;
        }
        return $arr_users;
    }
}