<?php namespace Guia\Models\Almacen;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model {

    //Salida __belongs_to__ Entrada
    public function entrada()
    {
        return $this->belongsTo('Guia\Models\Almacen\Entrada');
    }

    //Salida __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Salida __morphed_by_many__ Articulo
    public function articulos()
    {
        return $this->morphedByMany('Guia\Models\Articulo', 'articulo_salida');
    }

    //Salida __morphed_by_many__ NoreqArticulo
    public function noreq_articulos()
    {
        return $this->morphedByMany('Guia\Models\Almacen\NoreqArticulo', 'articulo_salida');
    }

}
