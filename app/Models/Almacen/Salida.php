<?php namespace Guia\Models\Almacen;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model {

    protected $fillable = ['entrada_id', 'fecha_salida', 'urg_id', 'cmt', 'responsable'];

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
        return $this->morphedByMany('Guia\Models\Articulo', 'salida_articulo')->withPivot('cantidad');
    }

    //Salida __morphed_by_many__ NoreqArticulo
    public function noreq_articulos()
    {
        return $this->morphedByMany('Guia\Models\Almacen\NoreqArticulo', 'salida_articulo')->withPivot('cantidad');
    }

}
