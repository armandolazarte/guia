<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Req extends Model {

    use SoftDeletes;

    //Req __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Req __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //Req __has_many__ Articulo
    public function articulos()
    {
        return $this->hasMany('Guia\Models\Articulo');
    }

    //Req __has_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->hasMany('Guia\Models\Cotizacion');
    }

    //Req __has_many__ Oc
    public function ocs()
    {
        return $this->hasMany('Guia\Models\Oc');
    }

    //Req __has_many__ Cuadro
    public function cuadros()
    {
        return $this->hasMany('Guia\Models\cuadros');
    }

}
