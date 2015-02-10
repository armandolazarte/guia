<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Vale extends Model {

    //Vale __belongs_to__ Egreso
    public function egreso()
    {
        return $this->belongsTo('Guia\Models\Egreso');
    }

    //Vale __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //Vale __belongs_to_many__ Reintegro
    public function reintegros()
    {
        return $this->belongsToMany('Guia\Models\Reintegro')->withPivot('monto');
    }

    //Vale __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto');
    }

    //Vale __belongs_to_many__ Objetivo
    public function objetivos()
    {
        return $this->belongsToMany('Guia\Models\Objetivo')->withPivot('monto');
    }

    //Vale __belongs_to_many__ Factura
    public function facturas()
    {
        return $this->belongsToMany('Guia\Models\Factura');
    }

}
