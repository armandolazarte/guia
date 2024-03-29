<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model {

    public $table = 'proveedores';
    protected $fillable = ['nombre_comercial','rfc','direccion','ciudad','estado','cp','tel','contacto','representante'];

    //Proveedor __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Proveedor __belongs_to_many__ Giros
    public function giros()
    {
        return $this->belongsToMany('Guia\Models\Giro');
    }

}
