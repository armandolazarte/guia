<?php namespace Guia;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model {

    public $timestamps = false;

    //Registro __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    public function docable()
    {
        return $this->morphTo();
    }
}
