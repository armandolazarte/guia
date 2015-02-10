<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Giro extends Model {

    public $timestamps = false;

    //Giro __belongs_to_many__ Proveedores
    public function proveedores()
    {
        return $this->belongsToMany('Guia\Models\Proveedor');
    }

}
