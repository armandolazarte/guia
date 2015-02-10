<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class RelInternaDoc extends Model {

    public $timestamps = false;

    //RelInternaDoc __belongs_to__ RelInterna
    public function relInterna()
    {
        return $this->belongsTo('Guia\Models\RelInterna');
    }

}
