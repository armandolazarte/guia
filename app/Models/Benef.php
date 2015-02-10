<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Benef extends Model {

    //Benef __has_many__ Egresos
    public function egresos()
    {
        return $this->hasMany('Guia\Models\Egreso');
    }

    //Benef __has_many__ Proveedores
    public function proveedores()
    {
        return $this->hasMany('Guia\Models\Proveedor');
    }

    //Benef __has_many__ Ocs
    public function ocs()
    {
        return $this->hasMany('Guia\Models\Oc');
    }

    //Benef __has_many__ Cotizaciones
    public function cotizaciones()
    {
        return $this->hasMany('Guia\Models\Cotizacion');
    }

    //Benef __has_many__ Solicitudes
    public function solicitudes()
    {
        return $this->hasMany('Guia\Models\Solicitud');
    }

}
