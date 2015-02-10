<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompDev extends Model {

    //CompsDev __belongs_to__ Comp
    public function comp()
    {
        return $this->belongsTo('Guia\Models\Comp');
    }

    //CompsDev __has_many__ CompDevsRm
    public function compDevsRms()
    {
        return $this->hasMany('Guia\Models\CompDevsRm');
    }

}
