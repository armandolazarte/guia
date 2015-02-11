<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    public $timestamps = false;

    //Role __belongs_to_many__ User
    public function users()
    {
        return $this->belongsToMany('Guia\User');
    }

    //Role __belongs_to_many__ Modulo
    public function modulos()
    {
        return $this->belongsToMany('Guia\Models\Modulo');
    }

}
