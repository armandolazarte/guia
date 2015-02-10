<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comp extends Model {

    use SoftDeletes;

    //Comp __has_many__ CompsDev
    public function compsDevs()
    {
        return $this->hasMany('Guia\Models\CompsDev');
    }

    //Comp __belongs_to_many__ Egreso
    public function egresos()
    {
        return $this->belongsToMany('Guia\Models\Egreso');
    }

    //Comp __belongs_to_many__ Paquete
    public function paquetes()
    {
        return $this->belongsToMany('Guia\Models\Paquete');
    }

    //Comp __belongs_to_many__ Factura
    public function facturas()
    {
        return $this->belongsToMany('Guia\Models\Factura');
    }

}
