<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    public $table = 'retenciones';
    public $timestamps = false;
    protected $fillable = ['doc_id','doc_type','rm_id','tipo_retencion','monto'];

    //Retencion __belongs_to__ Rm
    public function rm()
    {
        return $this->belongsTo('Guia\Models\Rm');
    }

    //Retencion __morph_to__ Solicitud
    public function docable()
    {
        return $this->morphTo();
    }

}
