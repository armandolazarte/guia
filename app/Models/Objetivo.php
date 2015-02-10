<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model {

    public $timestamps = false;

    //Objetivo __has_many__ Rm
    public function rms()
    {
        return $this->hasMany('Guia\Models\Rm');
    }

    //Objetivo __belongs_to_many__ Solicitud
    public function solicitudes()
    {
        return $this->belongsToMany('Guia\Models\Solicitud')->withPivot('monto');
    }

    //Objetivo __belongs_to_many__ Vales
    public function vales()
    {
        return $this->belongsToMany('Guia\Models\Vale')->withPivot('monto');
    }

}
