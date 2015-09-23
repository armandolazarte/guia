<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
    protected $fillable = ['fecha','tipo','concepto','user_id'];

    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    public function polizaCargos()
    {
        return $this->hasMany('Guia\Models\PolizaCargo');
    }

    public function polizaAbonos()
    {
        return $this->hasMany('Guia\Models\PolizaAbono');
    }

}
