<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model {

    public $table = 'acciones';
    public $timestamps = false;

    protected $fillable = ['ruta', 'nombre', 'icono', 'orden', 'activo'];

    //Accion __belongs_to_many__ Modulo
    public function modulos()
    {
        return $this->belongsToMany('Guia\Models\Modulo');
    }

}
