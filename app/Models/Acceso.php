<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model {

    //Acceso __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    //Acceso __morph_to__ TipoProyecto Fondo Urg Proyecto
    public function acceso()
    {
        return $this->morphTo();
    }

}
