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

    public static function fecha_texto($fecha)
    {
        $arr_fecha = explode('-',$fecha);
        $dia = $arr_fecha[2]*1;
        $mes = $arr_fecha[1];
        $a = $arr_fecha[0];

        switch ($mes)
        {
            case 01:$m='Enero';break;
            case 02:$m='Febrero';break;
            case 3:$m='Marzo';break;
            case 4:$m='Abril';break;
            case 5:$m='Mayo';break;
            case 6:$m='Junio';break;
            case 7:$m='Julio';break;
            case 8:$m='Agosto';break;
            case 9:$m='Septiembre';break;
            case 10:$m='Octubre';break;
            case 11:$m='Noviembre';break;
            case 12:$m='Diciembre';break;
        }
        $fecha_texto = $dia." de ".$m." de ".$a;

        return $fecha_texto;
    }

}