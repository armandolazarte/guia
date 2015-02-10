<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class BmsRm extends Model {

    //BmsRm __belongs_to__ Rm
    public function rm()
    {
        return $this->belongsTo('Guia\Models\Rm');
    }

}
