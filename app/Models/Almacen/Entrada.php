<?php namespace Guia\Models\Almacen;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model {

    //Entrada __has_many__ Salida
    public function salidas()
    {
        return $this->hasMany('Guia\Models\Almacen\Salida');
    }

    //Entrada __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Entrada __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Entrada __morphed_by_many__ Articulo
    public function articulos()
    {
        return $this->morphedByMany('Guia\Models\Articulo', 'entrada_articulo')->withPivot('cantidad');
    }

    //Entrada __morphed_by_many__ NoreqArticulo
    public function noreq_articulos()
    {
        return $this->morphedByMany('Guia\Models\Almacen\NoreqArticulo', 'entrada_articulo')->withPivot('cantidad');
    }

}
