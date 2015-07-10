<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oc extends Model {

    use SoftDeletes;

    //Oc __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Oc __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Oc __has_many__ Articulo
    public function articulos()
    {
        return $this->hasMany('Guia\Models\Articulo');
    }

    //Oc __has_one__ OcsCondicion
    public function condiciones()
    {
        return $this->hasOne('Guia\Models\OcsCondicion');
    }

    //Oc __belongs_to_many__ Egreso
    public function egresos()
    {
        return $this->belongsToMany('Guia\Models\Egreso');
    }

    //Oc __morph_many__ SolDepositoDocs
    public function solDepositosDocs()
    {
        return $this->morphMany('Guia\Models\SolDepositosDoc', 'doc');
    }

    public function archivos()
    {
        return $this->morphMany('Guia\Models\Archivos\Archivo', 'documento');
    }

    public function carpeta()
    {
        return $this->morphMany('Guia\Models\Archivos\Carpeta', 'documentos');
    }

}
