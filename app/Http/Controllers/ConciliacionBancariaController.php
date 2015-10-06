<?php

namespace Guia\Http\Controllers;

use Guia\Classes\FechasUtility;
use Guia\Models\Egreso;
use Guia\Models\Ingreso;
use Guia\Models\Poliza;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ConciliacionBancariaController extends Controller
{
    public $fecha_inicio;
    public $fecha_fin;
    public $cuenta_bancaria_id;

    public function auxiliarLibros($cuenta_bancaria_id, $aaaa, $mm)
    {
        $fecha = FechasUtility::fechasConciliacion($aaaa, $mm);
        $this->fecha_inicio = $fecha['inicial'];
        $this->fecha_fin = $fecha['final'];

        $this->cuenta_bancaria_id = $cuenta_bancaria_id;
        $auxiliar_registros = new Collection();

        $ingresos = $this->getIngresos();
        $ingresos->each(function ($item) use ($auxiliar_registros){
            $auxiliar_registros->push($item);
        });

        $egresos = $this->getEgresos();
        $egresos->each(function ($item) use ($auxiliar_registros) {
            $auxiliar_registros->push($item);
        });

        /**
         * @todo Consultar Pólizas de Ingresos (Pendiente hasta agregar cuenta_bancaria_id en tabla polizas)
         */
//        $polizas_ingreso = $this->getPolizasIngresos();
//        $auxiliar_registros->push($polizas_ingreso->map(function ($item){
//            return $item;
//        }));

        $canacelados = $this->getCancelados();
        $canacelados->map(function ($item) use ($auxiliar_registros) {
            $auxiliar_registros->push($item);
        });

        //Ordenar por fecha, poliza, cheque
        $auxiliar_registros = $auxiliar_registros->sortBy(function($aux) {
            return sprintf('%-12s %s %s', $aux->fecha, $aux->poliza, $aux->cheque);
        });

        return view('conciliacion.auxiliarLibros', compact('auxiliar_registros'));
    }

    private function getIngresos()
    {
        $ingresos = Ingreso::where('cuenta_bancaria_id', $this->cuenta_bancaria_id)
            ->whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin])
            ->with('cuenta')
            ->get();
        return ($ingresos);
    }

    private function getEgresos()
    {
        $egresos = Egreso::where('cuenta_bancaria_id', $this->cuenta_bancaria_id)
            ->whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin])
            ->with('benef','cuenta')
            ->get();
        return ($egresos);
    }

    private function getCancelados()
    {
        $cancelados = Egreso::onlyTrashed()
            ->where('cuenta_bancaria_id', $this->cuenta_bancaria_id)
            ->whereBetween('deleted_at', [$this->fecha_inicio, $this->fecha_fin])
            ->with('cuenta')
            ->get();
        return ($cancelados);
    }

    private function getPolizasIngresos()
    {
        $polizas_ingreso = Poliza::where('tipo', 'Ingreso')
            ->whereBetween('fecha', [$this->fecha_inicio, $this->fecha_fin])
            ->with(['polizaAbonos' => function ($query) {
                $query->where('cuenta_bancaria_id', $this->cuenta_bancaria_id);
            }])
            ->get();
        return ($polizas_ingreso);
    }
}
