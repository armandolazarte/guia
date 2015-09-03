<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaCargo extends Model
{
    public $timestamps = false;
    protected $fillable = ['poliza_id','cuenta_id','monto','origen_id','origen_type'];

    public function poliza()
    {
        return $this->belongsTo('Guia\Models\Poliza');
    }

    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto');
    }

    public function origen()
    {
        return $this->morphTo();
    }
}
