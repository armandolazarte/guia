<?php

namespace Guia\Classes;


use Guia\Models\OpExcepcion;
use Guia\Models\OpRestringida;
use Guia\Models\Proyecto;
use Guia\Models\Req;
use Guia\Models\Solicitud;

class ControlOperacionHelper
{
    public $modelo;
    public $proyecto_id;
    public $documento_id;
    public $op_restringida;

    public function __construct($modelo, $proyecto_id = null, $documento_id = null)
    {
        $this->modelo = $modelo;
        $this->proyecto_id = $proyecto_id;
        $this->documento_id = $documento_id;
    }

    public function validarOperacion()
    {
        $operacion = true;

        $hoy = \Carbon\Carbon::today()->toDateString();

        if (!$this->proyecto_id) {
            if ($this->modelo == 'Req') {
                $this->proyecto_id = Req::where('id', $this->documento_id)->pluck('proyecto_id');
            } elseif ($this->modelo == 'Solicitud') {
                $this->proyecto_id = Solicitud::where('id', $this->documento_id)->pluck('proyecto_id');
            }
        }
        $proyecto = Proyecto::find($this->proyecto_id);

        if (empty($proyecto)) {
            return false;
        }

        $op_restrigindas = OpRestringida::where('aaaa', $proyecto->aaaa)
            ->where('modelo', $this->modelo)
            ->whereNested(function($query) use ($hoy) {
                $query->where('inicio', '<=', $hoy);
//                $query->where('fin', '>=', $hoy);
            })
//            ->orWhere(function($query) use ($hoy) {
//                $query->where('inicio', '<=', $hoy);
//                $query->where('fin', '=', '0000-00-00');
//            })
            ->whereNested(function($query) use ($proyecto) {
                $query->orWhere(function($q) use ($proyecto) {
                    $q->where('aplica_type', 'Guia\Models\TipoProyecto');
                    $q->where('aplica_id', $proyecto->tipo_proyecto_id);
                });
                $query->orWhere(function($q) use ($proyecto) {
                    $q->where('aplica_type', 'Guia\Models\Urg');
                    $q->where('aplica_id', $proyecto->urg_id);
                });
                $query->orWhere(function($q) use ($proyecto) {
                    $q->where('aplica_type', 'Guia\Models\Proyecto');
                    $q->where('aplica_id', $proyecto->id);
                });
            })
            ->get();

        if (count($op_restrigindas) > 0) {
            $operacion = false;
            $this->op_restringida = $op_restrigindas[0];

            foreach ($op_restrigindas as $restriccion) {

                $excepcion = OpExcepcion::where('op_restringida_id', $restriccion->id)
                    ->whereNested(function($query) use ($hoy) {
                        $query->where('inicio', '<=', $hoy);
                        $query->where('fin', '>=', $hoy);
                    })
                    ->whereNested(function($query) use ($proyecto) {
                        $query->orWhere(function($q) use ($proyecto) {
                            $q->where('aplica_type', 'Guia\Models\TipoProyecto');
                            $q->where('aplica_id', $proyecto->tipo_proyecto_id);
                        });
                        $query->orWhere(function($q) use ($proyecto) {
                            $q->where('aplica_type', 'Guia\Models\Urg');
                            $q->where('aplica_id', $proyecto->urg_id);
                        });
                        $query->orWhere(function($q) use ($proyecto) {
                            $q->where('aplica_type', 'Guia\Models\Proyecto');
                            $q->where('aplica_id', $proyecto->id);
                        });
                        $query->orWhere(function($q) {
                            $q->where('aplica_type', 'Guia\User');
                            $q->where('aplica_id', \Auth::user()->id);
                        });
                    })
                    ->get();
                if (count($excepcion) > 0) {
                    $operacion = true;
                }
            }
        }

        return $operacion;
    }
}
