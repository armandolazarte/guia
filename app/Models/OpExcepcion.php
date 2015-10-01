<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class OpExcepcion extends Model
{
    public $table = 'op_excepciones';
    public $timestamps = false;
    protected $fillable = ['inicio','fin','aplica_id','aplica_type'];

    public function opRestringida()
    {
        return $this->belongsTo('Guia\Models\OpRestringida');
    }

    public function aplica()
    {
        return $this->morphTo();
    }
}
