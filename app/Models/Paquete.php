<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model {

    //Paquete __belongs_to_many__ Comp
    public function comps()
    {
        return $this->belongsToMany('Guia\Models\Comp');
    }

}
