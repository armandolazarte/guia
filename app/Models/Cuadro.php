<?php namespace Guia\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuadro extends Model {

    use SoftDeletes;

    protected $fillable = ['req_id', 'fecha_cuadro', 'estatus', 'elabora', 'revisa', 'autoriza', 'criterio_adj'];

    //Cuadro __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Cuadro __has_many__ Cotizacion
    public function cotizaciones()
    {
        return $this->hasMany('Guia\Models\Cotizacion');
    }

    public function getFechaCuadroInfoAttribute()
    {
        return Carbon::parse($this->fecha_cuadro)->format('d/m/Y');
    }

}
