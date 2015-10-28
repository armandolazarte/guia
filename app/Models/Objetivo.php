<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model {

    public $timestamps = false;
    protected $fillable = ['objetivo','d_objetivo','proyecto_id'];
    protected $appends = ['objetivo_desc'];

    //Objetivo __has_many__ Rm
    public function rms()
    {
        return $this->hasMany('Guia\Models\Rm');
    }

    //Objetivo __belongs_to__ Proyecto
    public function proyecto() {
        return $this->belongsTo('\Guia\Models\Proyecto');
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

    //Objetivo __belongs_to_many__ Reintegro
    public function reintegros()
    {
        return $this->belongsToMany('Guia\Models\Reintegro')->withPivot('monto');
    }

    public function getObjetivoDescAttribute() {
        return $this->objetivo.' '.$this->d_objetivo;
    }
}
