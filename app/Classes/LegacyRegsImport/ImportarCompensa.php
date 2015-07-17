<?php

namespace Guia\Classes\LegacyRegsImport;


use Guia\Models\CompensaDestino;
use Guia\Models\CompensaExterna;
use Guia\Models\CompensaOrigen;
use Guia\Models\CompensaRm;
use Guia\Models\Rm;
use Guia\Models\UrgExterna;

class ImportarCompensa
{
    public $db_origen;

    public function __construct($db_origen)
    {
        $this->db_origen = $db_origen;

        set_time_limit(240);
    }

    public function importarCompensaciones()
    {
        $cambios_cuenta = $this->consultaCambioCuenta();

        foreach ($cambios_cuenta as $cambio) {
            $cambio_origenes = $this->consultaCambioOrigen($cambio->cambio_id);
            $cambio_destinos = $this->consultaCambioDestino($cambio->cambio_id);

            $compensa_rm = CompensaRm::create(['fecha' => $cambio->fecha, 'tipo' => $cambio->tipo]);

            if (count($cambio_origenes) > 0) {
                foreach ($cambio_origenes as $origen) {
                    $origen_rm_id = Rm::whereRm($origen->rm_origen)->value('id');
                    $compensa_origen = new CompensaOrigen(['rm_id' => $origen_rm_id, 'monto' => $origen->monto]);
                    $compensa_rm->compensaOrigenes()->save($compensa_origen);
                }
            }

            if (count($cambio_destinos) > 0) {
                foreach ($cambio_destinos as $destino) {
                    $destino_rm_id = Rm::whereRm($destino->rm_destino)->value('id');
                    $compensa_destino = new CompensaDestino(['rm_id' => $destino_rm_id, 'monto' => $destino->monto]);
                    $compensa_rm->compensaDestinos()->save($compensa_destino);
                }
            }

            if ($cambio->tipo == 'ExternaIngreso' || $cambio->tipo == 'ExternaEgreso') {
                $legacy_comp_ext = $this->consultaCompensaExterna($cambio->cambio_id);
                $urg_externa_id = UrgExterna::whereUrgExterna($legacy_comp_ext->ures_ext)->pluck('id');
                if (empty($urg_externa_id)) {
                    $urg_externa_id = UrgExterna::whereUrgExterna('2.2')->pluck('id');
                }
                $compensa_externa = new CompensaExterna(['urg_externa_id' => $urg_externa_id, 'tipo' => $legacy_comp_ext->tipo, 'concepto' => $legacy_comp_ext->concepto]);
                $compensa_rm->compensaExternas()->save($compensa_externa);
            }
        }
    }

    private function consultaCambioCuenta()
    {
        $cambios_cuenta = \DB::connection($this->db_origen)->table('tbl_cambio_cuenta');

        return $cambios_cuenta->get();
    }

    private function consultaCambioOrigen($cambio_id)
    {
        $cambio_origenes = \DB::connection($this->db_origen)->table('tbl_cambio_origen')
            ->where('cambio_id', '=', $cambio_id);

        return $cambio_origenes->get();
    }

    private function consultaCambioDestino($cambio_id)
    {
        $cambio_destinos = \DB::connection($this->db_origen)->table('tbl_cambio_destino')
        ->where('cambio_id', '=', $cambio_id);

        return $cambio_destinos->get();
    }

    private function consultaCompensaExterna($cambio_id)
    {
        $compensa_externa = \DB::connection($this->db_origen)->table('tbl_comp_ext')
            ->where('cambio_id', '=', $cambio_id);

        return $compensa_externa->first();
    }

}
