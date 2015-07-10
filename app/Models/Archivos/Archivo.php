<?php

namespace Guia\Models\Archivos;


use Illuminate\Database\Eloquent\Model;

class Archivo extends Model {

    protected $fillable = ['carpeta_id', 'documento_id','documento_type','name','mime','size','created_original','extencion','tipo'];

    public function carpeta()
    {
        return $this->belongsTo('Guia\Models\Archivos\Carpeta');
    }

}
