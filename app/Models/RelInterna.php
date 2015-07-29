<?php

namespace Guia\Models;


use Illuminate\Database\Eloquent\Model;

class RelInterna extends Model {

    protected $fillable = ['fecha_envio','fecha_revision','envia','recibe','estatus','tipo_documentos'];

    //RelInterna __has_many__ RelInternaDoc
    public function relInternaDocs()
    {
        return $this->hasMany('Guia\Models\RelInternaDoc');
    }

}
