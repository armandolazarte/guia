<?php namespace Guia\Models\Almacen;

use Illuminate\Database\Eloquent\Model;

class NoreqArticulo extends Model {


    public function entradas()
    {
        return $this->morphToMany('Guia\Models\Almacen\Entrada', 'articulo_entrada');
    }

    public function salidas()
    {
        return $this->morphToMany('Guia\Models\Almacen\Salida', 'articulo_salida');
    }

}
