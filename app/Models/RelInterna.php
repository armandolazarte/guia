<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class RelInterna extends Model {

    //RelInterna __has_many__ RelInternaDoc
    public function relInternaDocs()
    {
        return $this->hasMany('Guia\Models\RelInternaDoc');
    }

}
