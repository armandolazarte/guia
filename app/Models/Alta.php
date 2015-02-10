<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Alta extends Model {

    //Alta __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

}
