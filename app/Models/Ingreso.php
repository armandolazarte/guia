<?php namespace Guia\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model {

    use SoftDeletes;
    protected $fillable = ['cuenta_bancaria_id','poliza','fecha','cuenta_id','concepto','monto'];

    //Ingreso __has_one__ SolDeposito
    public function solDeposito()
    {
        return $this->hasOne('Guia\Models\SolDeposito');
    }

    //Ingreso __belongs_to__ CuentaBancaria
    public function cuenta()
    {
        return $this->belongsTo('Guia\Models\CuentaBancaria');
    }

    //Ingreso __belongs_to__ Cuenta
    public function concepto()
    {
        return $this->belongsTo('Guia\Models\Cuenta');
    }

    //Ingreso __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto')->withTimestamps();
    }

    //Ingreso __morph_many__ PolizaOrigen
    public function polizaOrigen()
    {
        return $this->morphMany('Guia\Models\PolizaOrigen', 'origen');
    }

    public function getFechaInfoAttribute()
    {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

}
