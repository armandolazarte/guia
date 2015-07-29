<?php

namespace Guia\Models;


use Illuminate\Database\Eloquent\Model;

class RelInternaDoc extends Model {

    protected $fillable = ['rel_interna_id','validacion','docable_id','docable_type'];
    public $timestamps = false;

    //RelInternaDoc __belongs_to__ RelInterna
    public function relInterna()
    {
        return $this->belongsTo('Guia\Models\RelInterna');
    }

    //RelInternaDoc __morph_to__ Egreso
    public function docable()
    {
        return $this->morphTo();
    }

}
