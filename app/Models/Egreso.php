<?php namespace Guia\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Egreso extends Model {

    use SoftDeletes;
    protected $fillable = ['cuenta_bancaria_id','poliza','cheque','fecha','benef_id','cuenta_id','concepto','monto','estatus','user_id','fecha_cobro'];
    protected $appends = ['fecha_info'];

    //Egreso __belongs_to__ CuentaBancaria
    public function cuentaBancaria()
    {
        return $this->belongsTo('Guia\Models\CuentaBancaria');
    }

    //Egreso __belongs_to__ Cuenta
    public function cuenta()
    {
        return $this->belongsTo('Guia\Models\Cuenta');
    }

    //Egreso __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Egreso __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    //Egreso __has_many__ Reintegro
    public function reintegros()
    {
        return $this->hasMany('Guia\Models\Reintegro');
    }

    //Egreso __has_many__ Vales
    public function vales()
    {
        return $this->hasMany('Guia\Models\Vale');
    }

    //Egreso __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto')->withTimestamps();
    }

    //Egreso __belongs_to_many__ Comp
    public function comps()
    {
        return $this->belongsToMany('Guia\Models\Comp');
    }

    //Egreso __belongs_to_many__ Solicitud
    public function solicitudes()
    {
        return $this->belongsToMany('Guia\Models\Solicitud');
    }

    //Egreso __belongs_to_many__ Oc
    public function ocs()
    {
        return $this->belongsToMany('Guia\Models\Oc');
    }

    //Egreso __belongs_to_many__ Proyecto
    public function proyectos()
    {
        return $this->belongsToMany('Guia\Models\Proyecto')->withPivot('monto');
    }

    //Egreso __morph_many__ Archivo
    public function archivos()
    {
        return $this->morphMany('Guia\Models\Archivos\Archivo', 'documento');
    }

    //Egreso __morph_many__ Carpeta
    public function carpeta()
    {
        return $this->morphMany('Guia\Models\Archivos\Carpeta', 'documentos');
    }

    //Egreso __morph_many__ RelacionInternaDoc
    public function relacionInternaDocs()
    {
        return $this->morphMany('Guia\Models\RelInternaDoc', 'docable');
    }

    //Egreso __morph_many__ PolizaOrigen
    public function polizaOrigen()
    {
        return $this->morphMany('Guia\Models\PolizaOrigen', 'origen');
    }

    public function getFechaInfoAttribute()
    {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

}
