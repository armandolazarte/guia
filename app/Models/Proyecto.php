<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {

    //Proyecto __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Proyecto __belongs_to__ TipoProyecto
    public function tipoProyecto()
    {
        return $this->belongsTo('Guia\Models\TipoProyecto');
    }

    //Proyecto __has_many__ Rm
    public function rms()
    {
        return $this->hasMany('Guia\Models\Rm');
    }

    //Proyecto __has_many__ Req
    public function reqs()
    {
        return $this->hasMany('Guia\Models\Req');
    }

    //Proyecto __has_many__ Solicitud
    public function solicitudes()
    {
        return $this->hasMany('Guia\Models\Solicitud');
    }

    //Proyecto __has_many__ Vale
    public function vales()
    {
        return $this->hasMany('Guia\Models\Vale');
    }

    //Proyecto __has_many__ PreReq
    public function preReq()
    {
        return $this->hasMany('Guia\Models\PreReq');
    }

    //Proyecto __belongs_to_many Fondos
    public function fondos()
    {
        return $this->belongsToMany('Guia\Models\Fondo');
    }

    //Proyecto __belongs_to_many CuentaBancaria
    public function cuentasBancarias()
    {
        return $this->belongsToMany('Guia\Models\CuentaBancaria');
    }

    //Proyecto __belongs_to_many Disponibles
    public function disponibles()
    {
        return $this->belongsToMany('Guia\Models\Disponible')
            ->withPivot('monto','no_invoice');
    }

    //Proyecto __morph_many__ Acceso
    public function accesos()
    {
        return $this->morphMany('Guia\Models\Acceso', 'acceso');
    }

    public function getProyectoDescripcionAttribute()
    {
        return $this->proyecto.' - '.$this->d_proyecto;
    }

    public function scopeAcceso($query, $user_id, $presupuesto)
    {
        if(!empty($user_id)) {
            $arr_tipos_proyecto = array();
            $arr_urgs = array();
            $arr_proyectos = array();

            $accesos = Acceso::whereUserId($user_id)->get();

            foreach ($accesos as $acceso) {
                if ($acceso->acceso_type == 'Guia\Models\TipoProyecto') {
                    $arr_tipos_proyecto[] = $acceso->acceso_id;
                }
                if ($acceso->acceso_type == 'Guia\Models\Urg') {
                    $arr_urgs[] = $acceso->acceso_id;
                }
                if ($acceso->acceso_type == 'Guia\Models\Proyecto') {
                    $arr_proyectos[] = $acceso->acceso_id;
                }
            }

            if(count($arr_tipos_proyecto) > 0 || count($arr_urgs) > 0 || count($arr_proyectos) > 0){
                if (count($arr_tipos_proyecto) > 0) {
                    $query->orWhere(function($query) use ($arr_tipos_proyecto)
                    {
                        $query->whereIn('tipo_proyecto_id', $arr_tipos_proyecto);
                    });
                }
                if (count($arr_urgs) > 0) {
                    $query->orWhere(function($query) use ($arr_urgs)
                    {
                        $query->whereIn('urg_id', $arr_urgs);
                    });
                }
                if (count($arr_proyectos) > 0) {
                    $query->orWhere(function($query) use ($arr_proyectos)
                    {
                        $query->whereIn('id', $arr_proyectos);
                    });
                }

                //Filtro por fecha
                $query->whereNested(function($query) use ($presupuesto)
                {
                    $query->whereBetween('inicio', array($presupuesto.'-01-01', $presupuesto.'-12-31'));
                    $query->orWhere(function($query) use ($presupuesto)
                    {
                        $query->where('inicio', '<', $presupuesto.'-01-01');
                        $query->where('fin', '=', '0000-00-00');
                    });
                    $query->orWhere(function($query) use ($presupuesto)
                    {
                        $query->where('inicio', '<', $presupuesto.'-01-01');
                        $query->where('fin', '>=', $presupuesto.'-01-01');
                    });
                });
            } else {
                $query->whereId(0);
            }

        } else {
            $query->whereId(0);
        }
        return $query;
    }

    private function getFechasPresupuesto($presupuesto)
    {

    }
}
