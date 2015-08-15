<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model {

    public $table = "cuentas_bancarias";

    //CuentaBancaria __has_many__ Egresos
    public function egresos()
    {
        return $this->hasMany('Guia\Models\Egreso');
    }

    //CuentaBancaria __has_many__ Ingresos
    public function ingresos()
    {
        return $this->hasMany('Guia\Models\Ingreso');
    }

    //CuentaBancaria __belongs_to_many__ Proyectos
    public function proyectos()
    {
        return $this->belongsToMany('Guia\Models\Proyecto');
    }

    //CuentaBancaria __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    public function getCuentaTipoUrgAttribute()
    {
        return $this->cuenta_bancaria.' - '.$this->tipo.' ('.$this->urg->d_urg.')';
    }
}
