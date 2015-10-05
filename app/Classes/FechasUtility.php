<?php

namespace Guia\Classes;


class FechasUtility
{

    /**
     * Determina fecha
     * @param $aaaa
     * @param $mm
     * @return array
     */
    public static function fechasConciliacion($aaaa, $mm)
    {
        switch ($mm)
        {
            case 1:
                $f_inicial = $aaaa.'-01-01';
                $f_final = $aaaa.'-01-31';
                break;
            case 2:
                $f_anterior = $aaaa.'-01-31';
                $f_inicial = $aaaa.'-02-01';
                $f_final = $aaaa.'-02-29';
                break;
            case 3:
                $f_anterior = $aaaa.'-02-29';
                $f_inicial = $aaaa.'-03-01';
                $f_final = $aaaa.'-03-31';
                break;
            case 4:
                $f_anterior = $aaaa.'-03-31';
                $f_inicial = $aaaa.'-04-01';
                $f_final = $aaaa.'-04-30';
                break;
            case 5:
                $f_anterior = $aaaa.'-04-30';
                $f_inicial = $aaaa.'-05-01';
                $f_final = $aaaa.'-05-31';
                break;
            case 6:
                $f_anterior = $aaaa.'-05-31';
                $f_inicial = $aaaa.'-06-01';
                $f_final = $aaaa.'-06-30';
                break;
            case 7:
                $f_anterior = $aaaa.'-06-30';
                $f_inicial = $aaaa.'-07-01';
                $f_final = $aaaa.'-07-31';
                break;
            case 8:
                $f_anterior = $aaaa.'-07-31';
                $f_inicial = $aaaa.'-08-01';
                $f_final = $aaaa.'-08-31';
                break;
            case 9:
                $f_anterior = $aaaa.'-08-31';
                $f_inicial = $aaaa.'-09-01';
                $f_final = $aaaa.'-09-30';
                break;
            case 10:
                $f_anterior = $aaaa.'-09-30';
                $f_inicial = $aaaa.'-10-01';
                $f_final = $aaaa.'-10-31';
                break;
            case 11:
                $f_anterior = $aaaa.'-10-31';
                $f_inicial = $aaaa.'-11-01';
                $f_final = $aaaa.'-11-30';
                break;
            case 12:
                $f_anterior = $aaaa.'-11-30';
                $f_inicial = $aaaa.'-12-01';
                $f_final = $aaaa.'-12-31';
                break;
        }
        $fechas = ['anterior' => $f_anterior, 'inicial' => $f_inicial, 'final' => $f_final];

        return $fechas;
    }
}