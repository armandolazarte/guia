<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 22/09/2015
 * Time: 11:47 AM
 */

namespace Guia\Classes;


use Guia\Models\Egreso;
use Guia\Models\Proyecto;

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

        $montoReintegroDF = $this->getMontoReintegrosDF($proyecto);
        $ejercicio_global->put('reintegro_df', $montoReintegroDF);

        $montoValesSinRms = $this->getMontoValesSinRMs($proyecto);
        $ejercicio_global->put('valesNoComprobados', $montoValesSinRms);

        return $ejercicio_global;
    }

    private function getMontoReintegrosDF(Proyecto $proyecto)
    {
        $montoReintegroDF = $proyecto->egresos()->where('cuenta_id', 2)->sum('egreso_proyecto.monto');

        return round($montoReintegroDF, 2);
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
}
