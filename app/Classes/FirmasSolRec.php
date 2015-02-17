<?php

namespace Guia\Classes;


use Guia\Models\Cargo;
use Guia\Models\Proyecto;

class FirmasSolRec
{
    public static function getUserAutoriza($proyecto_id)
    {
        $urg = Proyecto::find($proyecto_id)->urg_id;
        $cargo = Cargo::whereUrgId($urg)->where('fin', '=', '0000-00-00')->get(array('user_id'));
        if (count($cargo) > 0){
            $user_id = $cargo[0]->user_id;
        } else {
            $user_id = 0;
        }
        return $user_id;
    }

    public static function getUsersVoBo()
    {
        $cargos = Cargo::with('user')->get();
        foreach($cargos as $cargo){
            $arr_users[] = $cargo->user;
        }
        return $arr_users;
    }
}