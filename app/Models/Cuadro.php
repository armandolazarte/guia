<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuadro extends Model {

    use SoftDeletes;

    //Cuadro __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Cuadro __belongs_to_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->belongsToMany('Guia\Models\Cotizacion')->withPivot('criterio');
    }

}
