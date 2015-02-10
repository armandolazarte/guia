<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProyecto extends Model {

    public $timestamps = false;

    //TipoProyecto __has_many__ Proyecto
    public function proyectos()
    {
        return $this->hasMany('Guia\Models\Proyecto');
    }

    //TipoProyecto __has_many__ Cog
    public function cog()
    {
        return $this->hasMany('Guia\Models\Cog');
    }

    //TipoProyecto __morph_many__ Acceso
    public function accesos()
    {
        return $this->morphMany('Guia\Models\Acceso', 'acceso');
    }

}
