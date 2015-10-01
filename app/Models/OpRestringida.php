<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class OpRestringida extends Model
{
    public $timestamps = false;
    protected $fillable = ['motivo','aaaa','modelo','mensaje','inicio','fin','aplica_id','aplica_type'];

    public function OpExcepciones()
    {
        return $this->hasMany('Guia\Models\OpExcepcion');
    }

    public function aplica()
    {
        return $this->morphTo();
    }
}
