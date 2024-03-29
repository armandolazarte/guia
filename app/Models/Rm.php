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

    //Rm __has_many__ Retencion
    public function retenciones()
    {
        return $this->hasMany('Guia\Models\Retencion');
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

    //Rm __belongs_to_many__ Articulo
    public function articulos()
    {
        return $this->belongsToMany('Guia\Models\Articulo')->withPivot('monto');
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

    //Rm __belongs_to_many__ PolizaCargo
    public function polizaCargos()
    {
        return $this->belongsToMany('Guia\Models\PolizaCargo')->withPivot('monto');
    }

    //Rm __belongs_to_many__ PolizaAbono
    public function polizaAbonos()
    {
        return $this->belongsToMany('Guia\Models\PolizaAbono')->withPivot('monto');
    }

    //Rm __belongs_to_many__ Comp
    public function comps()
    {
        return $this->belongsToMany('Guia\Models\Comp')->withPivot('monto');
    }

    public function getRmCogAttribute()
    {
        return $this->rm.' '.$this->cog->cog.' '.$this->cog->d_cog;
    }

    public function getCogRmSaldoAttribute()
    {
        /**
         * @todo Agregar cálculo del saldo por RM
         */
        return $this->cog->cog.' - '.$this->rm.' - $';
    }
}
