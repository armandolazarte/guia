<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model {

    public $timestamps = false;

    //Cuenta __has_many__ Egresos
    public function egresos()
    {
        return $this->hasMany('Guia\Models\Egreso');
    }

    //Cuenta __has_many__ Ingresos
    public function ingresos()
    {
        return $this->hasMany('Guia\Models\Ingreso');
    }

}
