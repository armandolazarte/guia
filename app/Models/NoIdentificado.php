<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class NoIdentificado extends Model
{
    protected $fillable = ['cuenta_bancaria_id','fecha','monto','no_deposito','identificado','fecha_identificado'];
    protected $dates = ['fecha','fecha_identificado'];

    //NoIdentificado __belongs_to__ CuentaBancaria
    public function cuentaBancaria()
    {
        return $this->belongsTo('Guia\Models\CuentaBancaria');
    }

    public function getFechaMontoAttribute()
    {
        return $this->fecha->format('d/m/Y').' :: $'.number_format($this->monto, 2);
    }
}
