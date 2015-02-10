<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Rm extends Model {

    //RM __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //RM __belongs_to__ Objetivo
    public function objetivo()
    {
        return $this->belongsTo('Guia\Models\Objetivo');
    }

    //RM __belongs_to__ Actividad
    public function actividad()
    {
        return $this->belongsTo('Guia\Models\Actividad');
    }

    //RM __belongs_to__ Cog
    public function cog()
    {
        return $this->belongsTo('Guia\Models\Cog');
    }

    //RM __belongs_to__ Fondo
    public function fondo()
    {
        return $this->belongsTo('Guia\Models\Fondo');
    }

    //Rm __has_many__ CompensaOrigen
    public function compensaOrigenes()
    {
        return $this->hasMany('Guia\Models\CompensaOrigen');
    }

    //Rm __has_many__ CompensaDestino
    public function compensaDestinos()
    {
        return $this->hasMany('Guia\Models\CompensaDestino');
    }

    //Rm __has_many__ Articulo
    public function articulos()
    {
        return $this->hasMany('Guia\Models\Articulo');
    }

    //Rm __has_many__ Honorario
    public function honorarios()
    {
        return $this->hasMany('Guia\Models\Honorario');
    }

    //Rm __has_many__ FacturaConcepto
    public function facturaConceptos()
    {
        return $this->hasMany('Guia\Models\FacturaConcepto');
    }

    //Rm __has_many__ BmsRm
    public function bmsRm()
    {
        return $this->hasMany('Guia\Models\BmsRm');
    }

    //RM __belongs_to_many__ Vale
    public function vales()
    {
        return $this->belongsToMany('Guia\Models\Vale')->withPivot('monto');
    }

    //RM __belongs_to_many__ Solicitud
    public function solicitudes()
    {
        return $this->belongsToMany('Guia\Models\Solicitud')->withPivot('monto');
    }

    //Rm __belongs_to_many__ Ingreso
    public function ingresos()
    {
        return $this->belongsToMany('Guia\Models\Ingreso')->withPivot('monto')->withTimestamps();
    }

    //Rm __belongs_to_many__ Egreso
    public function egresos()
    {
        return $this->belongsToMany('Guia\Models\Egreso')->withPivot('monto')->withTimestamps();
    }

}
