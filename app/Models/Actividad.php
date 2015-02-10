<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model {

    public $table = 'actividades';
    public $timestamps = false;

    //Actividad __has_many__ Rm
    public function rms()
    {
        return $this->hasMany('Guia\Models\Rm');
    }

}
