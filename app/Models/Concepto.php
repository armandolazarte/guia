<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model {

    public $timestamps = false;

    //Concepto __has_many__ Egresos
    public function egresos()
    {
        return $this->hasMany('Guia\Models\Egreso');
    }

    //Concepto __has_many__ Ingresos
    public function ingresos()
    {
        return $this->hasMany('Guia\Models\Ingreso');
    }

}
