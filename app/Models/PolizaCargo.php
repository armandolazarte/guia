<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaCargo extends Model
{
    public $timestamps = false;
    protected $fillable = ['poliza_id','cuenta_id','monto'];

    public function poliza()
    {
        return $this->belongsTo('Guia\Models\Poliza');
    }

    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto');
    }
}
