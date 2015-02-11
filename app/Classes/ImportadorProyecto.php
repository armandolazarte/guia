<?php namespace Guia\Classes;

use Guia\Models\Fondo;

class ImportadorProyecto {

    var $text;
    var $proy;
    var $fondo;
    var $d_fondo;
    var $d_proyecto;
    var $urg;
    var $d_urg;
    var $monto_proy;
    var $t_rm;
    var $buscar_bms;
    var $arr_partida;
    var $t_recursos;
    var $arr_cog;
    var $arr_drm;
    var $arr_monto;
    var $arr_rm_objetivo;
    var $arr_rm_d_objetivo;
    var $monto_total_cc;
    var $arr_recursos;
    var $aaaa;
    var $inicio;
    var $fin;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function convertir(){
        $output = `/usr/bin/pdftotext -enc Latin1 -layout {$this->file} ./uploads/proyectos/temp.txt`;
        return $output;
    }

    public function extraer()
    {
        $path = public_path();
        $this->text = \File::get($path.$this->file);

        $this->extraerProyecto();
        $this->extraerNombreProyecto();
        $this->extraerUrg();
        $this->extraerDescUrg();
        $this->extraerFechas();
        $this->extraerFondo();
        $this->extraerMontoProyecto();

        $this->extraerPartida();
        $this->extraerCog();
        $this->extraerMontoPartida();
        $this->extraerObjetivo();
        if ( count($this->arr_partida) == count($this->arr_cog) && count($this->arr_partida) == count($this->arr_monto) ) {
            for ($i = 0; $i < count($this->arr_partida); $i++) {
                $this->arr_recursos[$this->arr_partida[$i]]['cog'] = $this->arr_cog[$i];
                $this->arr_recursos[$this->arr_partida[$i]]['d_rm'] = $this->arr_drm[$i];
                $this->arr_recursos[$this->arr_partida[$i]]['monto'] = $this->arr_monto[$i];
                $this->arr_recursos[$this->arr_partida[$i]]['objetivo'] = $this->arr_rm_objetivo[$this->arr_partida[$i]];
                $this->arr_recursos[$this->arr_partida[$i]]['d_objetivo'] = $this->arr_rm_d_objetivo[$this->arr_partida[$i]];
            }
        }
    }

    private function extraerProyecto()
    {
        $t_proy = strstr($this->text, "Proyecto:");
        $pattern = '/[0-9]{1,7}/';
        preg_match($pattern, $t_proy, $matches);
        $this->proy = $matches[0];
    }

    private function extraerNombreProyecto()
    {
        $t_dproy = strstr($this->text, "Nombre del Proyecto: ");
        $posision_ures = strpos($t_dproy, "URG:");
        $t_dproy = substr($t_dproy, 21, $posision_ures-22 );
        $this->d_proyecto = rtrim(utf8_encode($t_dproy));
    }

    private function extraerUrg()
    {
        $t_urg = strstr($this->text, "URG:");
        $pattern = '/[0-9]\.(\.?[0-9][0-9]?)+/';
        preg_match($pattern, $t_urg, $matches);
        $this->urg = $matches[0];
    }

    private function extraerDescUrg()
    {
        $t_durg = strstr($this->text, utf8_decode("Descripción URG "));
        $pos_finlinea = strpos($t_durg, "\n");
        $this->d_urg = substr(utf8_encode($t_durg), 16, $pos_finlinea - 16);
    }

    private function extraerFechas(){
        $t_fechas = strstr($this->text, utf8_decode("o: "));
        $pattern = '/[0-9][0-9][0-9][0-9]/';
        preg_match($pattern, $t_fechas, $matches);
        $this->aaaa = $matches[0];

        $t_inicio = strstr($this->text, "Inicio: ");
        $pattern = '/[0-9][0-9]\/[0-9][0-9]\/[2][0-9][0-9][0-9]/';
        preg_match($pattern, $t_inicio, $matches);
        $this->inicio = $matches[0];

        $t_fin = strstr($this->text, "Fin: ");
        $pattern = '/[0-9][0-9]\/[0-9][0-9]\/[0-9][0-9][0-9][0-9]/';
        preg_match($pattern, $t_fin, $matches);
        $this->fin = $matches[0];
    }

    private function extraerFondo()
    {
        $t_fondo = strstr($this->text, "Fondo: ");
        $pos_limite = strpos($t_fondo, "Monto Total");
        $fondo_txt = substr($t_fondo, 0, $pos_limite);
        $fondo_txt = substr($fondo_txt, 7);
        $fondo_txt = trim($fondo_txt);
        $fondo_txt = str_replace(PHP_EOL, '', $fondo_txt);
        $fondo_txt = str_replace('      ', '', $fondo_txt);
        $fondo_txt = utf8_encode($fondo_txt);

        $fondo = Fondo::whereDFondo($fondo_txt)->get();
        if ( count($fondo) > 0 ){
            $this->fondo = $fondo[0]->fondo;
        }
        //@todo Agregar mensaje y bandera de error cuando no se encuentre el fondo
        //@todo Agregar fomulario emergente para dar de alta el fondo
        $this->d_fondo = $fondo_txt;
    }

    private function extraerMontoProyecto()
    {
        $t_monto = strstr($this->text, "Monto Total del proyecto");
        $pattern = '/(\$)[0-9]{1,3}(,[0-9]{1,3})*(\.)[0-9][0-9]/';
        preg_match($pattern, $t_monto, $matches);
        $this->monto_total_cc = $matches[0];
        $monto_ss = trim($this->monto_total_cc, "$");
        $monto_scoma = Utility::removerComa($monto_ss);
        $this->monto_proy = (float) $monto_scoma;
    }

    private function extraerPartida()
    {
        $t_partida = strstr($this->text, "GASTO PROGRAMADO");
        $lim_gasto_prog_1 = strpos($t_partida, "Contratos Laborales");
        $lim_gasto_prog_2 = strpos($t_partida, "Subtotal");
        if ( $lim_gasto_prog_1 > $lim_gasto_prog_2 ) {
            $lim_gasto_prog = $lim_gasto_prog_1;
            $this->restar_reg_monto = 1;
        } else {
            $lim_gasto_prog = $lim_gasto_prog_2;
            $this->restar_reg_monto = 0;
        }
        $this->t_recursos = substr($t_partida, 0, $lim_gasto_prog);
        $pattern = '/[0-9]{7}/';
        $encontrados = preg_match_all($pattern, $this->t_recursos, $matches);

        foreach ($matches[0] as $value) {
            if ( $value != $this->proy )
            {
                $this->arr_partida[] = $value;
            }
        }
    }

    private function extraerCog()
    {
        $t_cog = strstr($this->t_recursos, "COG");

        $pattern = '/[0-99](\.[0-9][0-9]?){3,4}/';
        $encontrados = preg_match_all($pattern, $t_cog, $matches);

        foreach ($matches[0] as $value) {
            $this->arr_cog[] = str_replace(".", "", $value);
        }
    }

    private function extraerMontoPartida ()
    {
        $t_monto = strstr($this->t_recursos, "Monto");

        $pattern = '/(\$)[0-9]{1,3}(,[0-9]{1,3})*(\.)[0-9][0-9]/';
        $encontrados = preg_match_all($pattern, $t_monto, $matches);

        for ($i = 0; $i < count($this->arr_partida); $i++) {
            if ( $matches[0][$i] != $this->monto_total_cc || count($this->arr_partida) == 1 ) {
                $value = trim($matches[0][$i], "$");
                $value = str_replace(",", "", $value);
                $this->arr_monto[] = $value;
            }
        }
    }

    private function extraerObjetivo()
    {
        $t_objetivos = $this->text;
        while ( $t_objetivos = strstr($t_objetivos, "Objetivo Particular:") )
        {
            $arr_match_obj = array();

            //Obtener No. Objetivo (siguiente número de 6 dígitos)
            //$obj = substr($t_objetivos, 22, 10);
            $patron_no_obj = '/[0-9]{6,}/';//Números con al menos 6 dígitos
            preg_match_all($patron_no_obj, $t_objetivos, $arr_match_obj);
            $no_obj = $arr_match_obj[0][0];

            //Obtener Descripción del Objetivo
            $t_d_objetivo = strstr($t_objetivos, utf8_decode("Alineación PDI"), true);
            $posision_obj = strpos($t_d_objetivo, $no_obj);
            $t_d_objetivo = trim($t_d_objetivo);
            $t_d_objetivo = substr($t_d_objetivo, $posision_obj+8);
            $d_objetivo = utf8_encode($t_d_objetivo);

            //Obtener RMs del objetivo
            $pos_siguiente_obj = strpos($t_objetivos, "Objetivo Particular", 20);
            if ( $pos_siguiente_obj != false ) {
                $t_partidas = substr($t_objetivos, 0, $pos_siguiente_obj);
                $t_objetivos = substr($t_objetivos, $pos_siguiente_obj);//Elimina el texto evaluado en $t_partidas de $t_objetivos
            } else {
                //Para el caso del último objetivo
                $t_partidas = $t_objetivos;
                $t_objetivos = "";//Se indica que no queda texto por evaluar (rompe el ciclo while)
            }
            $arr_match_rm = array();
            $patron_rm = '/[0-9]{7,}/';//Números con al menos 7 dígitos
            preg_match_all($patron_rm, $t_partidas, $arr_match_rm);
            foreach ($arr_match_rm[0] as $rm) {
                if ( $rm != $this->proy )
                {
                    $this->arr_rm_objetivo[$rm] = $no_obj;
                    $this->arr_rm_d_objetivo[$rm] = $d_objetivo;
                }
            }
        }
    }
}