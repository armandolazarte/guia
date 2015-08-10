<?php namespace Guia\Models;

use Carbon\Carbon;
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

    public function getFechaInfoAttribute()
    {
        return Carbon::parse($this->fecha_req)->format('d/m/Y');
    }

    public function scopeEstatusResponsable($query, $arr_estatus, $arr_responsable)
    {
        $ids_proyectos = \FiltroAcceso::getIdsProyectos();
        $query->whereIn('proyecto_id', $ids_proyectos);

        if(count($arr_estatus) > 0){
            $query->whereIn('estatus', $arr_estatus);
        }

        if(count($arr_responsable) > 0){
            $query->whereIn('user_id', $arr_responsable);
        }

        if(count($arr_estatus) == 0 && count($arr_responsable) == 0){
            $query->whereId(0);
        }

        return $query;
    }

    public function scopeMisReqs($query)
    {
        $ids_proyectos = \FiltroAcceso::getIdsProyectos();
        $query->whereIn('proyecto_id', $ids_proyectos);
        $query->whereSolicita(\Auth::user()->id);

        return $query;
    }

    public function scopeSeguimiento($query)
    {
        $ids_proyectos = \FiltroAcceso::getIdsProyectos();
        $query->whereIn('proyecto_id', $ids_proyectos);
        $query->whereNotIn('estatus', ['','Cancelada'])->orderBy('req', 'DESC');

        return $query;
    }

}
