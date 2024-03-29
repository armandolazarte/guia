<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articulo extends Model {

    use SoftDeletes;
    protected $fillable = ['req_id','articulo','cantidad','impuesto','monto','oc_id','unidad','inventariable','no_cotizado','obs'];

    //Articulo __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Articulo __belongs_to__ Oc
    public function oc()
    {
        return $this->belongsTo('Guia\Models\Oc');
    }

    //Articulo __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto');
    }

    //Articulo __belongs_to_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->belongsToMany('Guia\Models\Cotizacion')->withPivot('costo', 'sel')->withTimestamps();
    }

    public function entradas()
    {
        return $this->morphToMany('Guia\Models\Almacen\Entrada', 'entrada_articulo')->withPivot('cantidad');
    }

    public function salidas()
    {
        return $this->morphToMany('Guia\Models\Almacen\Salida', 'salida_articulo')->withPivot('cantidad');
    }

    public function getMontoCotizadoAttribute()
    {
        foreach ($this->cotizaciones as $cot) {
            if ($cot->pivot->sel == 1) {
                $monto_cotizado = $cot->pivot->costo;
            }
        }

        //Excepción para cuando hay cotizaciones pero aún no se elige el proveedor
        if(!isset($monto_cotizado)) {
            $monto_cotizado = 0;
        }

        return $monto_cotizado;
    }

    public function getSubTotalAttribute()
    {
        return $this->monto_cotizado * $this->cantidad;
    }

    public function getMontoTotalAttribute()
    {
        return $this->sub_total * (($this->impuesto * 0.01) + 1);
    }

}
