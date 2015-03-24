<?php namespace Guia\Classes;

use Guia\Models\Actividad;
use Guia\Models\Cargo;
use Guia\Models\Objetivo;
use Guia\Models\Rm;
use Guia\Models\Urg;
use Guia\Models\Fondo;
use Guia\Models\Proyecto;
use Guia\Models\Cuenta;
use Guia\Models\Benef;
use Guia\Models\Proveedor;
use Guia\Models\Cog;
use Guia\User;

class ImportadorCatalogos {

    var $db_origen;

    public function __construct($db_origen){
        $this->db_origen = $db_origen;
    }

    //URG
    public function importarUrgs(){
        $urg_externas = $this->consultarUrgExternas();
        if ( count($urg_externas) > 0 ) {
            foreach($urg_externas as $urg_nueva)
            {
                $urg = new Urg;
                $urg->urg = $urg_nueva->ures;
                $urg->d_urg = $urg_nueva->d_ures;
                $urg->save();
            }
        }
    }
    private function consultarUrgExternas(){
        $urg_importadas = Urg::lists('urg');
        if ( count($urg_importadas) > 0 ) {
            $urg_externas = \DB::connection($this->db_origen)->table('tbl_ures')
                ->whereNotIn ('ures', $urg_importadas)
                ->get();
        } else {
            $urg_externas = \DB::connection($this->db_origen)->table('tbl_ures')
                ->get();
        }
        return $urg_externas;
    }

    //Fondos
    public function importarFondos(){
        $fondos_externos = $this->consultarFondosExternos();
        if ( count($fondos_externos) > 0 ) {
            foreach($fondos_externos as $fondo_nuevo)
            {
                $fondo = new Fondo();
                $fondo->fondo = $fondo_nuevo->fondo;
                $fondo->d_fondo = $fondo_nuevo->d_fondo;
                $fondo->tipo = $fondo_nuevo->tipo;
                $fondo->save();
            }
        }
    }

    private function consultarFondosExternos(){
        $fondos_importados = Fondo::lists('fondo');
        if ( count($fondos_importados) > 0 ) {
            $fondos_externos = \DB::connection($this->db_origen)->table('tbl_fondos')
                ->whereNotIn ('fondo', $fondos_importados)
                ->get();
        } else {
            $fondos_externos = \DB::connection($this->db_origen)->table('tbl_fondos')
                ->get();
        }
        return $fondos_externos;
    }

    //Proyectos P3E-LGCG
    public function importarProyectos(){
        $proyectos_externos = $this->consultarProyectosExternos();
        if ( count($proyectos_externos) > 0 ) {
            foreach($proyectos_externos as $proyecto_nuevo)
            {
                $urg = Urg::whereUrg($proyecto_nuevo->ures)->get(array('id'));

                $proyecto = new Proyecto();
                $proyecto->proyecto = $proyecto_nuevo->proy;
                $proyecto->d_proyecto = $proyecto_nuevo->d_proy;
                $proyecto->monto = $proyecto_nuevo->monto;
                $proyecto->urg_id = $urg[0]->id;
                $proyecto->tipo_proyecto_id = 1;
                $proyecto->save();

                $proyecto_fondo = \DB::connection($this->db_origen)->table('tbl_proyecto_fondo')
                    ->where('proy', '=', $proyecto_nuevo->proy)
                    ->get();
                $fondo = Fondo::whereFondo($proyecto_fondo[0]->fondo)->get(array('id'));
                $proyecto->fondos()->attach($fondo[0]->id);
            }
        }
    }

    private function consultarProyectosExternos(){
        $proyectos_importados = Proyecto::lists('proyecto');
        if ( count($proyectos_importados) > 0 ) {
            $proyectos_externos = \DB::connection($this->db_origen)->table('tbl_proyectos')
                ->whereNotIn ('proy', $proyectos_importados)
                ->get();
        } else {
            $proyectos_externos = \DB::connection($this->db_origen)->table('tbl_proyectos')
                ->get();
        }
        return $proyectos_externos;
    }

    //Cuentas Bancarias
    public function importarCuentas(){
        $cuentas_externas = $this->consultarCuentasExternas();
        if ( count($cuentas_externas) > 0 ) {
            foreach($cuentas_externas as $cuenta_nueva)
            {
                $urg = Urg::whereUrg($cuenta_nueva->ures)->get(array('id'));
                !empty($cuenta_nueva->set_default) ? $activa = 1 : $activa = 0;

                $cuenta = new Cuenta();
                $cuenta->cuenta = $cuenta_nueva->cta_b;
                $cuenta->d_cuenta = $cuenta_nueva->d_cta_b;
                $cuenta->no_cuenta = $cuenta_nueva->no_cuenta;
                $cuenta->banco = $cuenta_nueva->banco;
                $cuenta->tipo = $cuenta_nueva->tipo;
                $cuenta->activa = $activa;
                $cuenta->urg_id = $urg[0]->id;
                $cuenta->save();
            }
        }
    }
    private function consultarCuentasExternas(){
        $cuentas_importadas = Cuenta::lists('cuenta');
        if ( count($cuentas_importadas) > 0 ) {
            $cuentas_externas = \DB::connection($this->db_origen)->table('tbl_cta_b')
                ->whereNotIn ('cta_b', $cuentas_importadas)
                ->get();
        } else {
            $cuentas_externas = \DB::connection($this->db_origen)->table('tbl_cta_b')
                ->get();
        }
        return $cuentas_externas;
    }

    //Beneficiarios
    public function importarBenefs(){
        $benefs_externos = $this->consultarBenefsExternos();
        if ( count($benefs_externos) > 0 ) {
            foreach($benefs_externos as $benef_nuevo)
            {
                $benef = new Benef();
                $benef->benef = $benef_nuevo->benef;
                $benef->tipo = $benef_nuevo->tipo;
                $benef->tel = $benef_nuevo->tel;
                $benef->correo = $benef_nuevo->correo;
                $benef->save();

                //Proveedores
                $prov_externo = \DB::connection($this->db_origen)->table('tbl_proveedor')
                    ->whereBenefId($benef_nuevo->benef_id)
                    ->get();
                if ( count($prov_externo) > 0 ) {
                    $proveedor = new Proveedor();
                    $proveedor->benef_id = $benef->id;
                    $proveedor->rfc = $prov_externo[0]->RFC;
                    $proveedor->direccion = $prov_externo[0]->direccion;
                    $proveedor->ciudad = $prov_externo[0]->ciudad;
                    $proveedor->cp = $prov_externo[0]->cp;
                    $proveedor->tel = $prov_externo[0]->tel;
                    $proveedor->contacto = $prov_externo[0]->contacto;
                    $proveedor->representante = $prov_externo[0]->representante;
                    $proveedor->save();
                }
            }
        }
    }

    private function consultarBenefsExternos(){
        $benefs_importados = Benef::lists('benef');
        if ( count($benefs_importados) > 0 ) {
            $benefs_externos = \DB::connection($this->db_origen)->table('tbl_benef')
                ->whereNotIn ('benef', $benefs_importados)
                ->get();
        } else {
            $benefs_externos = \DB::connection($this->db_origen)->table('tbl_benef')
                ->get();
        }
        return $benefs_externos;
    }

    //COG P3E-LGCG
    public function importarCog(){
        $cogs_externos = $this->consultarCogExternos();
        if ( count($cogs_externos) > 0 ) {
            foreach($cogs_externos as $cog_nuevo)
            {
                $cog = new Cog();
                $cog->tipo_proyecto_id = 1;
                $cog->cog = $cog_nuevo->cta;
                $cog->d_cog = $cog_nuevo->d_cta;
                $cog->save();
            }
        }
    }

    private function consultarCogExternos(){
        $cogs_importados = Cog::lists('cog');
        if ( count($cogs_importados) > 0 ) {
            $cogs_externos = \DB::connection($this->db_origen)->table('tbl_cuentas')
                ->whereNotIn ('cta', $cogs_importados)
                ->get();
        } else {
            $cogs_externos = \DB::connection($this->db_origen)->table('tbl_cuentas')
                ->get();
        }
        return $cogs_externos;
    }

    public function importarUsuarios(){
        $usuarios_externos = $this->consultarUsuariosExternos();
        if ( count($usuarios_externos) > 0 ) {
            foreach($usuarios_externos as $usuario_nuevo)
            {
                $user = new User();
                $user->username = $usuario_nuevo->usr;
                $user->email = $usuario_nuevo->correo;
                if(!empty($usuario_nuevo->correo)){
                    $temp_password = $usuario_nuevo->correo;
                } else {
                    $temp_password = $usuario_nuevo->usr;
                }
                $user->password = bcrypt($temp_password);
                $user->nombre = $usuario_nuevo->nombre;
                $user->cargo = $usuario_nuevo->cargo;

                if ($usuario_nuevo->prefijo == null){
                    $usuario_nuevo->prefijo = '';
                }
                $user->prefijo = $usuario_nuevo->prefijo;

                if ($usuario_nuevo->iniciales == null){
                    $usuario_nuevo->iniciales = '';
                } else {
                    $user->iniciales = $usuario_nuevo->iniciales;
                }

                $urg = Urg::whereUrg($usuario_nuevo->lim_inf)->get(array('id'));
                if (count($urg) > 0) {
                    $user->adscripcion = $urg[0]->id;
                }
                $user->save();
            }
        }
    }

    private function consultarUsuariosExternos(){
        $usuarios_importados = User::lists('username');
        if ( count($usuarios_importados) > 0 ) {
            $usuarios_externos = \DB::connection($this->db_origen)->table('tbl_usuarios')
                ->whereNotIn ('usr', $usuarios_importados)
                ->get();
        } else {
            $usuarios_externos = \DB::connection($this->db_origen)->table('tbl_usuarios')
                ->get();
        }
        return $usuarios_externos;
    }

    //RMs
    public function importarRms(){
        set_time_limit(60);
        $rms_externos = $this->consultarRmsExternos();
        if ( count($rms_externos) > 0 ) {
            foreach($rms_externos as $rm_nuevo)
            {
                $proyecto = Proyecto::whereProyecto($rm_nuevo->proy)->get(array('id'));
                $cog = Cog::whereCog($rm_nuevo->cta)->get(['id']);
                $fondo = Fondo::whereFondo($rm_nuevo->fondo)->get(array('id'));

                if( count($cog) == 0 || count($fondo) == 0){
                    dd('RM c/error: '.$rm_nuevo->rm);
                }

                $rms = new Rm();
                $rms->rm = $rm_nuevo->rm;
                $rms->proyecto_id = $proyecto[0]->id;

                if(empty($rm_nuevo->objetivo)){
                    $rms->objetivo_id = 1;
                } else {
                    $obj = Objetivo::whereObjetivo($rm_nuevo->objetivo)->get(['id']);
                    if(count($obj) == 0){
                        $objetivo = new Objetivo();
                        $objetivo->objetivo = $rm_nuevo->objetivo;
                        $objetivo->save();
                        $rms->objetivo_id = $objetivo->id;
                    } else {
                        $rms->objetivo_id = $obj[0]->id;
                    }
                }

                if(empty($rm_nuevo->actividad)){
                    $rms->actividad_id = 1;
                } else {
                    $act = Actividad::whereActividad($rm_nuevo->actividad)->get(['id']);
                    if(count($act) == 0){
                        $actividad = new Actividad();
                        $actividad->actividad = $rm_nuevo->actividad;
                        $actividad->save();
                        $rms->actividad_id = $actividad->id;
                    } else {
                        $rms->actividad_id = $act[0]->id;
                    }
                }

                $rms->cog_id = $cog[0]->id;
                $rms->fondo_id = $fondo[0]->id;
                $rms->monto = $rm_nuevo->monto;
                $rms->d_rm = '';
                $rms->save();
            }
        }
    }

    private function consultarRmsExternos(){
        $rms_importados = Rm::lists('rm');
        if ( count($rms_importados) > 0 ) {
            $rms_externos = \DB::connection($this->db_origen)->table('tbl_rm')
                ->whereNotIn ('rm', $rms_importados)
                ->get();
        } else {
            $rms_externos = \DB::connection($this->db_origen)->table('tbl_rm')
                ->get();
        }
        return $rms_externos;
    }
}