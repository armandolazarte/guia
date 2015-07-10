<?php

namespace Guia\Models\Archivos;

use Illuminate\Database\Eloquent\Model;

class CarpetaDocumento extends Model
{
    public $timestamps = false;
    protected $fillable = ['carpeta_id','documento_id','documento_type'];

    //CarpetaDocumentos __morph_to__  Solicitud||Req||Oc||Egreso||Ingreso
    public function documento()
    {
        return $this->morphTo();
    }
}
