<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 22/09/2015
 * Time: 11:47 AM
 */

namespace Guia\Classes;


use Guia\Models\Articulo;
use Guia\Models\Egreso;
use Guia\Models\Proyecto;
use Guia\Models\Req;
use Guia\Models\Solicitud;

class EjercicioProyecto
{
    public $proyecto_id;
    public $ejercicio_proyecto;

    public function __construct($proyecto_id)
    {
        $this->proyecto_id = $proyecto_id;
    }

    public function ejercicioRms()
    {
        $e_rms = new EjercicioRms();
        $ejercicio_rms = $e_rms->getEjericioRmsProyecto($this->proyecto_id);

        return $ejercicio_rms;
    }

    public function ejercicioGlobal()
    {
        $proyecto = Proyecto::findOrFail($this->proyecto_id);

        $ejercicio_global = collect(['presupuestado' => $proyecto->monto]);

        $montoEjercido = $this->getMontoEjercido($proyecto);
        $ejercicio_global->put('ejercido', $montoEjercido);

        $montoReintegroDF = $this->getMontoReintegrosDF($proyecto);
        $ejercicio_global->put('reintegro_df', $montoReintegroDF);

        $montoValesSinRms = $this->getMontoValesSinRMs($proyecto);
        $ejercicio_global->put('valesNoComprobados', $montoValesSinRms);

        $montoReservado = $this->getMontoReservado($proyecto);
        $ejercicio_global->put('reservado', $montoValesSinRms);

        $saldo = $proyecto->monto - $montoEjercido + $montoReintegroDF - $montoValesSinRms - $montoReservado;
        $ejercicio_global->put('saldo', $saldo);

        return $ejercicio_global;
    }

    private function getMontoReintegrosDF(Proyecto $proyecto)
    {
        $montoReintegroDF = $proyecto->egresos()->where('cuenta_id', 2)->sum('egreso_proyecto.monto');

        return round($montoReintegroDF, 2);
    }

    private function getMontoEjercido(Proyecto $proyecto)
    {
        $montoEjercido = $proyecto->egresos()->where('cuenta_id', 1)->sum('egreso_proyecto.monto');
        /**
         * @todo Descontar "Cargos" existentes en Pólizas
         */

        return round($montoEjercido, 2);
    }

    public function reporteEjercido()
    {
        $proyecto = Proyecto::findOrFail($this->proyecto_id);
        $ejercido = $proyecto->egresos()->where('cuenta_id', 1)
            ->with('benef','cuenta','user')
            ->get();
        /**
         * @todo Descontar "Cargos" existentes en Pólizas
         */

        return $ejercido;
    }

    private function getMontoValesSinRMs(Proyecto $proyecto)
    {
        $egresos_comprobados = $this->getEgresosComprobados($proyecto);
        $montoValesSinRms = $proyecto->egresos()
            ->where('cuenta_id', 1)
            ->whereHas('solicitudes', function ($query) {
                $query->where('tipo_solicitud', 'Vale');
            })
            ->whereNotIn('id', $egresos_comprobados)
            ->sum('egreso_proyecto.monto');

        return round($montoValesSinRms, 2);
    }

    private function getEgresosComprobados(Proyecto $proyecto)
    {
        $egresos = Egreso::whereHas('proyectos', function ($query) use ($proyecto) {
                $query->where('proyectos.id', $proyecto->id);
            })
            ->whereHas('solicitudes', function ($query) {
                $query->where('tipo_solicitud', 'Vale');
            })
            ->whereHas('comps', function ($query) {
                $query->has('Rms');
            })
            ->get(['id']);

        $egresos_id_comprobados = $egresos->toArray();

        return $egresos_id_comprobados;
    }

    private function getMontoReservado(Proyecto $proyecto)
    {
        $reqs_id = Req::where('proyecto_id', $proyecto->id)->where('estatus', 'Autorizada')->lists('id')->all();
        $articulos = Articulo::whereIn('req_id', $reqs_id)->with('rms')->get();
        $reservado_reqs = $articulos->sum('articulo_rm.monto');

        //$reservado_reqs = round($rm_objeto->articulos()->whereIn('req_id', $reqs_id)->sum('articulo_rm.monto'),2);
        $reservado_solicitudes = round(Solicitud::where('proyecto_id', $proyecto->id)->where('estatus', 'Autorizada')->sum('monto'), 2);
        $montoReservado = $reservado_reqs + $reservado_solicitudes;

        return round($montoReservado, 2);
    }
}
