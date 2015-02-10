<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model {

    public $timestamps = false;

    //Modulo __belongs_to_many__ Role
    public function roles()
    {
        return $this->belongsToMany('Guia\Models\Role');
    }

    //Modulo __belongs_to_many__ Accion
    public function acciones()
    {
        return $this->belongsToMany('Guia\Models\Accion');
    }

}
