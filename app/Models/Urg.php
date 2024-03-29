<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Urg extends Model {

    //Urg __has_many__ Proyecto
    public function proyectos()
    {
        return $this->hasMany('Guia\Models\Proyecto');
    }

    //Urg __has_many__ CuentaBancaria
    public function cuentasBancarias()
    {
        return $this->hasMany('Guia\Models\CuentaBancaria');
    }

    //Urg __has_many__ Alta
    public function altas()
    {
        return $this->hasMany('Guia\Models\Alta');
    }

    //Urg __has_many__ Solicitud
    public function solicitudes()
    {
        return $this->hasMany('Guia\Models\Solicitud');
    }

    //Urg __has_many__ Req
    public function reqs()
    {
        return $this->hasMany('Guia\Models\Req');
    }

    //Urg __has_many__ PreReq
    public function preReq()
    {
        return $this->hasMany('Guia\Models\PreReq');
    }

    //Urg __belongs_to_many__ Cargo
    public function cargos()
    {
        return $this->belongsToMany('Guia\Models\Cargo');
    }

    //Urg __morph_many__ Acceso
    public function accesos()
    {
        return $this->morphMany('Guia\Models\Acceso', 'acceso');
    }

    /**
     * Concatena los atributos urg y d_urg
     *
     * @return string
     */
    public function getUrgDescAttribute()
    {
        return $this->urg.' - '.$this->d_urg;
    }

}
