<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Fondo extends Model {

    //Fondo __belongs_to_many Proyectos
    public function proyectos()
    {
        return $this->belongsToMany('Guia\Models\Proyecto');
    }

    //Fondo __has_many__ Disponible
    public function disponibles()
    {
        return $this->hasMany('Guia\Models\Disponible');
    }

    //Fondo __has_many__ SolDeposito
    public function depositos()
    {
        return $this->hasMany('Guia\Models\SolDeposito');
    }

    //Fondo __morph_many__ Acceso
    public function accesos()
    {
        return $this->morphMany('Guia\Models\Acceso', 'acceso');
    }

    public function scopeFondosProyectosActivos($query)
    {
        $query->has('proyectos', '!=', 0);

        return $query;
    }

    //Regrega el fondo junto con su descripción
    public function getFondoDescAttribute()
    {
        return $this->fondo.' - '.$this->d_fondo;
    }

}
