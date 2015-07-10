<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model {

    public $table = 'solicitudes';

    protected $fillable = ['fecha', 'benef_id', 'tipo_solicitud', 'urg_id', 'proyecto_id', 'concepto', 'obs', 'no_documento', 'no_afin', 'monto', 'solicita', 'autoriza', 'vobo', 'viaticos'];

    //Solicitud __belongs_to__ Benef
    public function benef()
    {
        return $this->belongsTo('Guia\Models\Benef');
    }

    //Solicitud __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //Solicitud __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //Solicitud __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    //Solicitud __has_many__ SolicitudDev
    public function solicitudDevs()
    {
        return $this->hasMany('Guia\Models\SolicitudDev');
    }

    //Solicitud __belongs_to_many__ Egreso
    public function egresos()
    {
        return $this->belongsToMany('Guia\Models\Egreso');
    }

    //Solicitud __belongs_to_many__ Factura
    public function facturas()
    {
        return $this->belongsToMany('Guia\Models\Factura');
    }

    //Solicitud __belongs_to_many__ Rm
    public function rms()
    {
        return $this->belongsToMany('Guia\Models\Rm')->withPivot('monto');
    }

    //Solicitud __belongs_to_many__ Objetivo
    public function objetivos()
    {
        return $this->belongsToMany('Guia\Models\Objetivo')->withPivot('monto');
    }

    //Solicitud __morph_many__ Registro
    public function registros()
    {
        return $this->morphMany('Guia\Models\Registro', 'docable');
    }

    public function archivos()
    {
        return $this->morphMany('Guia\Models\Archivos\Archivo', 'documentos');
    }

    public function carpeta()
    {
        return $this->morphMany('Guia\Models\Archivos\Carpeta', 'documentos');
    }

    //Solicitud __morph_many__ SolDepositoDocs
    public function solDepositosDocs()
    {
        return $this->morphMany('Guia\Models\SolDepositosDoc', 'doc');
    }

}
