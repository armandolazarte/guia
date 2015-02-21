<?php

namespace Guia\Classes;

use Guia\Models\Urg;

class InfoDirectivos
{

    public function getResponsable($urg_alias)
    {
        $urg = $this->getUrg($urg_alias);
        $cargo = Urg::whereUrg($urg)->first()
            ->cargos()->first();
        /*
         * @todo Determinar responsable por fecha
         * @todo Catch error (si el reponsable no ha sido asignado)
         */
        return $cargo->user;
    }

    public function getUrg($urg_alias)
    {
        switch ($urg_alias) {
            case "REC": $urg = '2.2.1'; break;
            case "SAC": $urg = '2.2.2'; break;
            case "SAD": $urg = '2.2.3'; break;
            case "FIN": $urg = '2.2.3.3'; break;
            case "CONTA": $urg = '2.2.3.3.2'; break;
            case "PRESU": $urg = '2.2.3.3.3'; break;
            case "CSG": $urg = '2.2.3.5'; break;
            case "ADQ": $urg = '2.2.3.5.2'; break;
        }
//        if ($aaaa < 2013) {
//            switch ($urg_alias) {
//                case "REC": $urg = 222000; break;
//                case "SAC": $urg = 223000; break;
//                case "SAD": $urg = 224000; break;
//                case "FIN": $urg = 224007; break;
//                case "CONTA": $urg = 224009; break;
//                case "PRESU": $urg = 224010; break;
//                case "CSG": $urg = '224016'; break;
//                case "ADQ": $urg = 224018; break;
//            }
//        }
        return $urg;
    }
}