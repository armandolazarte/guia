<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    protected $fillable = ['fecha','tipo'];

    public function polizaCargos()
    {
        return $this->hasMany('Guia\Models\PolizaCargo');
    }

    public function polizaAbonos()
    {
        return $this->hasMany('Guia\Models\PolizaAbono');
    }

    public function polizaOrigenes()
    {
        return $this->hasMany('Guia\Models\PolizaOrigen');
    }
}