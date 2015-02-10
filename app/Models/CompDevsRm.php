<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompDevsRm extends Model {

    public $timestamps = false;

    //CompDevsRm __belongs_to__ CompDev
    public function compDev()
    {
        return $this->belongsTo('Guia\Models\CompDev');
    }

}
