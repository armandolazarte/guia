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

}
