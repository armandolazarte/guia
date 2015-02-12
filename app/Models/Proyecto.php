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

    //Proyecto __belongs_to_many Fondos
    public function fondos()
    {
        return $this->belongsToMany('Guia\Models\Fondo');
    }

    //Proyecto __belongs_to_many Cuentas
    public function cuentas()
    {
        return $this->belongsToMany('Guia\Models\Cuenta');
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

    public function scopeAcceso($query, $user_id)
    {
        if(!empty($user_id)) {
            $arr_tipos_proyecto = array();
            $arr_urgs = array();
            $arr_proyectos = array();

            $accesos = Acceso::whereUserId($user_id)->get();

            foreach ($accesos as $acceso) {
                if ($acceso->acceso_type == 'TipoProyecto') {
                    $arr_tipos_proyecto[] = $acceso->acceso_id;
                }
                if ($acceso->acceso_type == 'Urg') {
                    $arr_urgs[] = $acceso->acceso_id;
                }
                if ($acceso->acceso_type == 'Proyecto') {
                    $arr_proyectos[] = $acceso->acceso_id;
                }
            }

            if (count($arr_tipos_proyecto) > 0) {
                $query->whereIn('tipo_proyecto_id', $arr_tipos_proyecto);
            }
            if (count($arr_urgs) > 0) {
                $query->whereIn('urg_id', $arr_urgs);
            }
            if (count($arr_proyectos) > 0) {
                $query->whereIn('id', $arr_proyectos);
            }
        } else {
            $query->whereId(0);
        }
        return $query;
    }
}
