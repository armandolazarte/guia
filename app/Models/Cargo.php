<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model {

    public $timestamps = false;

    //Cargo __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\Models\User');
    }

    //Cargo __belongs_to__ Urg
    public function urgs()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

}
