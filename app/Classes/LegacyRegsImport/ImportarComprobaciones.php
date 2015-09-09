<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\Cog;
use Guia\Models\Comp;
use Guia\Models\CuentaBancaria;
use Guia\Models\Egreso;
use Guia\Models\Factura;
use Guia\Models\Rm;
use Guia\User;

class ImportarComprobaciones
{
    public $db_origen;
    public $arr_rango;
    public $col_rango;
    public $cuentas_bancarias;

    public function __construct($db_origen, $col_rango, $arr_rango)
    {
        set_time_limit(480);
        $this->db_origen = $db_origen;

        if(count($arr_rango) == 2 && !empty($col_rango)) {
            $this->arr_rango = $arr_rango;
            $this->col_rango = $col_rango;
        }

        $this->getCuentasBancarias();
    }

    public function importarComps()
    {
        $comps_legacy = \DB::connection($this->db_origen)->table('tbl_comp_info');
        if (!empty($this->col_rango)) {
            $comps_legacy->whereBetween($this->col_rango, $this->arr_rango);
        }
        $comps_legacy->chunk(100, function($comprobaciones) {
            foreach ($comprobaciones as $comp_legacy) {
                $this->registrarComprobacion($comp_legacy);
            }
        });
    }

    private function registrarComprobacion($comp_legacy)
    {
        $user_id = $this->getUserId($comp_legacy->responsable);
        $elabora = $this->getUserId($comp_legacy->usr_elabora);

        $comp = Comp::create([
            'oficio_c' => $comp_legacy->oficio_c,
            'estatus' => $comp_legacy->estatus,
            'comp_siiau' => $comp_legacy->comp_siiau,
            'user_id' => $user_id,
            'elabora' => $elabora,
            'created_at' => '',
            'updated_at' => ''
        ]);

        $comp_chegs = \DB::connection($this->db_origen)->table('tbl_comprobacion')
            ->where('comp_id', '=', $comp_legacy->comp_id)
            ->get();
        foreach($comp_chegs as $comp_cheg) {
            $cuenta_bancaria_id = $this->getCuentaBancariaId($comp_cheg->cta_b);

            if(!empty($cuenta_bancaria_id)) {
                $egreso = Egreso::where('cuenta_bancaria_id', '=', $cuenta_bancaria_id);
                if($comp_cheg->tipo == 'ch') {
                    $egreso->where('cheque', '=', $comp_cheg->ch_eg);
                } else {
                    $egreso->where('poliza', '=', $comp_cheg->ch_eg);
                }
                $egreso = $egreso->first();

                if(empty($egreso->id)) {
                    dd('Egreso no encontrado '.$comp_cheg->ch_eg);
                }

                //Crear Relación
                $egreso->comps()->save($comp);
            }

            $gxc_id = $this->getGxCId($comp_cheg);

            if (!empty($gxc_id) && $gxc_id > 0) {
                $this->importarCompRms($comp, $gxc_id);
                $this->importarFacturas($comp, $gxc_id);
            }
        }
    }

    private function getGxCId($comp_cheg)
    {
        $gxc_id = \DB::connection($this->db_origen)->table('tbl_gxc')
            ->where('cta_b', '=', $comp_cheg->cta_b)
            ->where('poliza', '=', $comp_cheg->ch_eg)
            ->where('tipo', '=', $comp_cheg->tipo)
            ->value('gxc_id');

        if (!empty($gxc_id)) {
            return $gxc_id;
        } else {
            return 0;
        }
    }

    private function importarCompRms(Comp $comp, $gxc_id)
    {
        $gxc_rms = \DB::connection($this->db_origen)->table('tbl_gxc_rm')
            ->where('gxc_id', '=', $gxc_id)
            ->get();
        foreach ($gxc_rms as $gxc_rm) {
            $rm = $this->getRm($gxc_rm->rm);
            if(!empty($rm)) {
                $comp->rms()->attach($rm->id, ['monto' => $gxc_rm->monto_c]);
            }
        }
    }

    private function importarFacturas(Comp $comp, $gxc_id)
    {
        $gxc_facts = \DB::connection($this->db_origen)->table('tbl_gxc_fact')
            ->where('gxc_id', '=', $gxc_id)
            ->get();

        foreach ($gxc_facts as $gxc_fact) {
            //GetInfoFactura
            $fact_info = \DB::connection($this->db_origen)->table('tbl_fact_info')
                ->where('id_factura', '=', $gxc_fact->id_factura)
                ->first();

            if (!empty($fact_info)) {
                $factura = Factura::create([
                    'rfc' => $fact_info->RFC,
                    'serie' => $fact_info->serie,
                    'factura' => $fact_info->factura,
                    'fecha' => $fact_info->fecha,
                    'subtotal' => $fact_info->subtotal,
                    'iva' => $fact_info->iva,
                    'total' => $fact_info->total,
                    'cfd' => $fact_info->cfd
                ]);

                $comp->facturas()->save($factura);
                $this->importarFacturasConceptos($factura, $gxc_fact->id_factura);
            }
        }
    }

    private function importarFacturasConceptos(Factura $factura, $id_factura)
    {
        //GetFacturaConceptos
        $fact_cs = \DB::connection($this->db_origen)->table('tbl_fact_c')
            ->where('id_factura', '=', $id_factura)
            ->get();

        foreach ($fact_cs as $fact_c) {
            $rm = $this->getRm($fact_c->rm);
            if (!empty($rm)) {
                $factura->facturaConceptos()->create([
                    'cantidad' => $fact_c->cantidad,
                    'concepto' => $fact_c->concepto,
                    'rm_id' => $rm->id,
                    'cog_id' => $rm->cog_id,
                    'inventariable' => $fact_c->alta_patrimonial,
                    'monto' => $fact_c->monto
                ]);
            }
        }
    }

    private function getRm($rm)
    {
        $rm = Rm::whereRm($rm)->first();
        return $rm;
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

    private function getUserId($legacy_user)
    {
        $user_id = User::whereLegacyUsername($legacy_user)->pluck('id');
        return $user_id;
    }

}