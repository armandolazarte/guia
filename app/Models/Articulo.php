<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulo extends Model {

    use SoftDeletes;

    //Articulo __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Articulo __belongs_to__ Oc
    public function oc()
    {
        return $this->belongsTo('Guia\Models\Oc');
    }

    //Articulo __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm');
    }

    //Articulo __belongs_to_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->belongsToMany('Guia\Models\Cotizacion')->withPivot('costo', 'sel')->withTimestamps();
    }

}
