<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model {

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

    //Cuenta __belongs_to_many__ Proyectos
    public function proyectos()
    {
        return $this->belongsToMany('Guia\Models\Proyecto');
    }

    //Cuenta __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

}
