<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Proyecto;

class ImportarProyectoVales
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;
    public $cuentas_bancarias;

    public function __construct($db_origen, $col_rango, $arr_rango)
    {
        set_time_limit(240);
        $this->db_origen = $db_origen;

        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->getCuentasBancarias();
    }

    private function registrarProyectoEgreso($gxc)
    {
        //Determinar proyecto_id
        $proyecto_id = Proyecto::where('proyecto', 'LIKE', $gxc->proy)->pluck('id');

        //Enconrar egreso_id
        $cuenta_bancaria_id = $this->getCuentaBancariaId($gxc->cta_b);
        if(!empty($cuenta_bancaria_id)) {



            $egreso = Egreso::where('cuenta_bancaria_id', '=', $cuenta_bancaria_id);
            if($gxc->tipo == 'ch') {
                $egreso->where('cheque', '=', $gxc->poliza);
                $legacy_fecha = \DB::connection($this->db_origen)->table('tbl_cheques')
                    ->where('cta_b', $gxc->cta_b)
                    ->where('cheque', $gxc->poliza)
                    ->pluck('fecha');
            } else {
                $egreso->where('poliza', '=', $gxc->poliza);
                $legacy_fecha = \DB::connection($this->db_origen)->table('tbl_egresos')
                    ->where('cta_b', $gxc->cta_b)
                    ->where('egreso_id', $gxc->poliza)
                    ->pluck('fecha');
            }
            $egreso->where('fecha', $legacy_fecha);
            $egreso = $egreso->first();

            if(empty($egreso->id)) {
                dd('Egreso no encontrado '.$gxc->poliza);
            }

            //Crear Relación
            $egreso->proyectos()->attach($proyecto_id, ['monto' => round($gxc->monto,2)]);
        }
    }

    public function importarProyectoEgreso()
    {
        $vales = \DB::connection($this->db_origen)->table('tbl_gxc')->where('estatus', '!=', 'CANCELADO');
        if (!empty($this->col_rango)) {
            $vales->whereBetween($this->col_rango, $this->arr_rango);
        }
        $vales->chunk(100, function($vs) {
            foreach ($vs as $vale) {
                $this->registrarProyectoEgreso($vale);
            }
        });
    }

    private function getCuentaBancariaId($cta_b)
    {
        $cuenta_bancaria_id = $this->cuentas_bancarias->search($cta_b);
        return $cuenta_bancaria_id;
    }

    private function getCuentasBancarias()
    {
        $cuentas_bancarias = CuentaBancaria::all(['id','cuenta_bancaria']);
        $this->cuentas_bancarias = $cuentas_bancarias->pluck('cuenta_bancaria', 'id');
    }
}