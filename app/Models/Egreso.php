<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egreso extends Model {

    use SoftDeletes;

    //Egreso __belongs_to__ Cuenta
    public function cuenta()
    {
        return $this->belongsTo('Guia\Models\Cuenta');
    }

    //Egreso __belongs_to__ Concepto
    public function concepto()
    {
        return $this->belongsTo('Guia\Models\Concepto');
    }

    //Egreso __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Egreso __has_many__ Honorarios
    public function honorarios()
    {
        return $this->hasMany('Guia\Models\Honorario');
    }

    //Egreso __has_many__ Vales
    public function vales()
    {
        return $this->hasMany('Guia\Models\Vale');
    }

    //Egreso __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto')->withTimestamps();
    }

    //Egreso __belongs_to_many__ Comp
    public function comps()
    {
        return $this->belongsToMany('Guia\Models\Comp');
    }

    //Egreso __belongs_to_many__ Solicitud
    public function solicitudes()
    {
        return $this->belongsToMany('Guia\Models\Solicitud');
    }

    //Egreso __belongs_to_many__ Oc
    public function ocs()
    {
        return $this->belongsToMany('Guia\Models\Oc');
    }

}
