<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Urg extends Model {

    //Urg __has_many__ Proyecto
    public function proyectos()
    {
        return $this->hasMany('Guia\Models\Proyecto');
    }

    //Urg __has_many__ Cuenta
    public function cuentas()
    {
        return $this->hasMany('Guia\Models\Cuenta');
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

    //Urg __has_many__ Cargo
    public function cargos()
    {
        return $this->hasMany('Guia\Models\Cargo');
    }

    //Urg __morph_many__ Acceso
    public function accesos()
    {
        return $this->morphMany('Guia\Models\Acceso', 'acceso');
    }

}
