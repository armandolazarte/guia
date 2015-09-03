<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class NoIdentificado extends Model
{
    protected $fillable = ['cuenta_bancaria_id','fecha','monto','no_deposito','identificado'];

    //NoIdentificado __belongs_to__ CuentaBancaria
    public function cuentaBancaria()
    {
        return $this->belongsTo('Guia\Models\CuentaBancaria');
    }
}
