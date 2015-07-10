<?php

namespace Guia\Models\Archivos;

use Illuminate\Database\Eloquent\Model;

class Carpeta extends Model
{
    public $timestamps = false;
    protected $fillable = ['ruta','zip'];

    //Carpeta __has_many__ Archivo
    public function archivos()
    {
        return $this->hasMany('Guia\Models\Archivos\Archivo');
    }

    //Carpeta __has_many__ CarpetaDocumetno
    public function documentos()
    {
        return $this->hasMany('Guia\Models\Archivos\CarpetaDocumento');
    }

}
