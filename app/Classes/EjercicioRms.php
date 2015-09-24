<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 22/09/2015
 * Time: 11:47 AM
 */

namespace Guia\Classes;


use Guia\Models\CompensaDestino;
use Guia\Models\CompensaOrigen;
use Guia\Models\Req;
use Guia\Models\Rm;
use Guia\Models\Solicitud;

class EjercicioRms
{

    public function getEjericioProyecto($proyecto_id)
    {
        $rms = Rm::whereProyectoId($proyecto_id)->with('objetivo','cog')->get();

        $coll_rms = collect();
        foreach ($rms as $rm) {
            $coll_rms->put($rm->rm, $this->getEjercicioRm($rm));
        }
        $ejercicio_rms = collect(['rms' => $coll_rms]);

        $coll_totales = collect([
           't_presu' => $ejercicio_rms->get('rms')->sum('presupuestado'),
           't_compensa' => $ejercicio_rms->get('rms')->sum('compensado'),
           't_ejercido' => $ejercicio_rms->get('rms')->sum('ejercido'),
           't_reintegros_df' => $ejercicio_rms->get('rms')->sum('reintegros_df'),
           't_reservado' => $ejercicio_rms->get('rms')->sum('reservado'),
           't_comp_vales' => $ejercicio_rms->get('rms')->sum('comprobado_vales'),
           't_saldo' => $ejercicio_rms->get('rms')->sum('saldo'),
        ]);
        $ejercicio_rms->put('total', $coll_totales);

        return $ejercicio_rms;
    }

    public function getEjercicioRm($rm)
    {
        $ejercicio_rm = collect(['rm' => $rm->rm]);
        $ejercicio_rm->put('objetivo', $rm->objetivo->objetivo);
        $ejercicio_rm->put('cog', $rm->cog->cog);
        $ejercicio_rm->put('d_cog', $rm->cog->d_cog);
        $ejercicio_rm->put('presupuestado', $rm->monto);

        $compensado_origen = CompensaOrigen::where('rm_id', $rm->id)->sum('monto');
        $compensado_destino = CompensaDestino::where('rm_id', $rm->id)->sum('monto');
        $compensado = round($compensado_destino,2) - round($compensado_origen,2);
        $ejercicio_rm->put('compensado',$compensado);

        $rm_objeto = Rm::find($rm->id);

        $ejercido = $this->getMontoEjercido($rm_objeto);
        $ejercicio_rm->put('ejercido', $ejercido);

        $reintegros_df = $this->getMontoReintegrosDF($rm_objeto);
        $ejercicio_rm->put('reintegros_df', $reintegros_df);

        //-- Reservado --//
        $reqs_id = Req::where('proyecto_id', $rm->proyecto_id)->where('estatus', 'Autorizada')->lists('id')->all();
        $reservado_reqs = round($rm_objeto->articulos()->whereIn('req_id', $reqs_id)->sum('articulo_rm.monto'),2);
        $solicitudes_id = Solicitud::where('proyecto_id', $rm->proyecto_id)->where('estatus', 'Autorizada')->lists('id')->all();
        $reservado_solicitudes = round($rm_objeto->solicitudes()->whereIn('solicitud_id', $solicitudes_id)->sum('rm_solicitud.monto'),2);
        $reservado = $reservado_reqs + $reservado_solicitudes;

        $ejercicio_rm->put('reservado', $reservado);

        $ejercicio_rm->put('comprobado_vales', 0);


        $saldo = $ejercicio_rm->get('presupuestado')
            + $ejercicio_rm->get('compensado')
            - $ejercicio_rm->get('ejercido')
            - $ejercicio_rm->get('reservado');

        $ejercicio_rm->put('saldo', round($saldo,2));

        return $ejercicio_rm;
    }

    private function getMontoEjercido(Rm $rm)
    {
        $egresos = round($rm->egresos()->where('cuenta_id', 1)->sum('egreso_rm.monto'),2);
        $abonos = round($rm->polizaAbonos()->sum('poliza_abono_rm.monto'),2);
        $cargos = round($rm->polizaCargos()->sum('poliza_cargo_rm.monto'),2);
        $ejercido = $egresos + $abonos - $cargos;

        return round($ejercido, 2);
    }

    private function getMontoReintegrosDF(Rm $rm)
    {
        $monto_reintegros_df = $rm->egresos()->where('cuenta_id', 2)->sum('egreso_rm.monto');

        return round($monto_reintegros_df, 2);
    }
}