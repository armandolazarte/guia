<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Req extends Model {

    use SoftDeletes;

    //Req __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Req __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //Req __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    //Req __has_many__ Articulo
    public function articulos()
    {
        return $this->hasMany('Guia\Models\Articulo');
    }

    //Req __has_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->hasMany('Guia\Models\Cotizacion');
    }

    //Req __has_many__ Oc
    public function ocs()
    {
        return $this->hasMany('Guia\Models\Oc');
    }

    //Req __has_many__ Cuadro
    public function cuadros()
    {
        return $this->hasMany('Guia\Models\Cuadro');
    }

    //Req __has_many__ PreReqArticulo
    public function preReqArticulo()
    {
        return $this->hasMany('Guia\Models\PreReqArticulo');
    }

    //Req __morph_many__ Registro
    public function registros()
    {
        return $this->morphMany('Guia\Models\Registro', 'docable');
    }

    public function scopeEstatusResponsable($query, $arr_estatus, $arr_responsable)
    {
        if(count($arr_estatus) > 0){
            $query->whereIn('estatus', $arr_estatus);
        }

        if(count($arr_responsable) > 0){
            $query->whereIn('responsable', $arr_responsable);
        }

        if(count($arr_estatus) == 0 && count($arr_responsable) == 0){
            $query->whereId(0);
        }

        return $query;
    }

    public function scopeMisReqs($query)
    {
        /**
         * @todo Filtrar proyectos
         */

        $query->whereSolicita(\Auth::user()->id);

        return $query;
    }

}
