<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Cog extends Model {

    public $timestamps = false;

    //Cog __belongs_to__ ProyectoTipo
    public function tipoProyectos()
    {
        return $this->belongsTo('Guia\Models\ProyectoTipo');
    }

    //Cog __has_many__ Rm
    public function rms()
    {
        return $this->hasMany('Guia\Models\Rm');
    }

    //Cog __has_many__ FacturaConcepto
    public function facturaConceptos()
    {
        return $this->hasMany('Guia\Models\FacturaConcepto');
    }

}
