<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Disponible extends Model {

    //Disponible __belongs_to__ Fondo
    public function fondo()
    {
        return $this->belongsTo('Guia\Models\Fondo');
    }

    //Disponible __belongs_to_many__ Proyectos
    public function proyectos()
    {
        return $this->belongsToMany('Guia\Models\Proyecto')
            ->withPivot('monto','no_invoice');
    }

}
