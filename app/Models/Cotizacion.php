<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model {

    public $table = 'cotizaciones';
    use SoftDeletes;

    //Cotizacion __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Cotizacion __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benefs');
    }

    //Cotizacion __belongs_to_many__ Articulo
    public function articulos()
    {
        return $this->belongsToMany('Guia\Models\Articulo')->withPivot('costo', 'sel')->withTimestamps();
    }

    //Cotizacion __belongs_to_many__ Cuadro
    public function cuadros()
    {
        return $this->belongsToMany('Guia\Models\Cuadro')->withPivot('criterio');
    }

}
