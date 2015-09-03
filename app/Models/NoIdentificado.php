<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class NoIdentificado extends Model
{
    //NoIdentificado __belongs_to__ CuentaBancaria
    public function cuentaBancaria()
    {
        return $this->belongsTo('Guia\Models\CuentaBancaria');
    }
}
