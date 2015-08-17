<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class PolizaOrigen extends Model
{
    public $table = 'poliza_origenes';
    public $timestamps = false;
    protected $fillable = ['poliza_id','origen_id','origen_type'];

    public function poliza()
    {
        return $this->belongsTo('Guia\Models\Poliza');
    }

    public function origen()
    {
        return $this->morphTo();
    }
}
