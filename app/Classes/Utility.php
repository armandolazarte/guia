<?php namespace Guia\Classes;

class Utility {

    public static function removerComa($numero) {
        $numero_sin_coma = "";
        $arr_num = explode(",", $numero);
        foreach ($arr_num AS $n)
        {
            $numero_sin_coma .= $n;
        }
        return  $numero_sin_coma;
    }
}