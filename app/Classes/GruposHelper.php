<?php

namespace Guia\Classes;


use Guia\User;

class GruposHelper
{

    /**
     * Obtiene un arreglo con los usuarios en los grupos colectivos a los que pertenece un usuario
     *
     * @param $user_id
     * @return array
     */
    public function getGruposColectivos ($user_id)
    {
        $grupos_usuarios = User::find($user_id)->grupos()
            ->where('tipo', 'LIKE', '%Colectivo%')
            ->with(['users' => function($query){
                //$query->wherePivot('supervisa', '!=', 1);//Elimina de la consulta a supervisores
                $query->addSelect(['user_id']);
            }])->get();
        $grupos_usuarios = $grupos_usuarios->map(function ($grupo){
            return $grupo->users->pluck('user_id');
        });
        $arr_usuarios_grupo = [];
        foreach ($grupos_usuarios as $grupo) {
            foreach ($grupo as $user_id) {
                //Genera $arr_usuarios_grupo para filtrar documentos por user_id
                $arr_usuarios_grupo[] = $user_id;
            }
        }

        return $arr_usuarios_grupo;
    }

}
