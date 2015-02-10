<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model {

    use SoftDeletes;

    //Ingreso __belongs_to__ Cuenta
    public function cuenta()
    {
        return $this->belongsTo('Guia\Models\Cuenta');
    }

    //Ingreso __belongs_to__ Concepto
    public function concepto()
    {
        return $this->belongsTo('Guia\Models\Concepto');
    }

    //Ingreso __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto')->withTimestamps();
    }

}
