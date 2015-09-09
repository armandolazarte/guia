<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model {

    protected $fillable = ['rfc','serie','factura','fecha','subtotal','iva','total','cfd'];

    //Factura __has_many__ FacturaConcepto
    public function facturaConceptos()
    {
        return $this->hasMany('Guia\Models\FacturaConcepto');
    }

    //Factura __belongs_to_many__ Vale
    public function vales()
    {
        return $this->belongsToMany('Guia\Models\Vale');
    }

    //Factura __belongs_to_many__ Solicitud
    public function solicitudes()
    {
        return $this->belongsToMany('Guia\Models\Solicitud');
    }

    //Factura __belongs_to_many__ CompFactura
    public function compFacturas()
    {
        return $this->belongsToMany('Guia\Models\CompFactura');
    }

}
