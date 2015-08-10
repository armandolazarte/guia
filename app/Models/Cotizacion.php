<?php namespace Guia\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotizacion extends Model {

    public $table = 'cotizaciones';
    use SoftDeletes;

    protected $fillable = ['req_id', 'cuadro_id', 'benef_id', 'fecha_invitacion', 'fecha_cotizacion', 'vigencia', 'garantia', 'imprimir'];

    //Cotizacion __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

    //Cotizacion __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Cotizacion __belongs_to_many__ Articulo
    public function articulos()
    {
        return $this->belongsToMany('Guia\Models\Articulo')->withPivot('costo', 'sel')->withTimestamps();
    }

    //Cotizacion __belongs_to__ Cuadro
    public function cuadro()
    {
        return $this->belongsTo('Guia\Models\Cuadro');
    }

    public function getFechaInvitacionInfoAttribute()
    {
        return Carbon::parse($this->fecha_invitacion)->format('d/m/Y');
    }

    public function getFechaCotizacionInfoAttribute()
    {
        return Carbon::parse($this->fecha_cotizacion)->format('d/m/Y');
    }

}
