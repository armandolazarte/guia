<?php

namespace Guia\Models;


use Carbon\Carbon;
use Guia\User;
use Illuminate\Database\Eloquent\Model;

class RelInterna extends Model {

    protected $fillable = ['fecha_envio','fecha_revision','envia','recibe','estatus','tipo_documentos'];

    //RelInterna __has_many__ RelInternaDoc
    public function relInternaDocs()
    {
        return $this->hasMany('Guia\Models\RelInternaDoc');
    }

    //RelInterna __morph_to__ User|Grupo
    public function destino()
    {
        return $this->morphTo();
    }

    public function getFechaEnvioInfoAttribute()
    {
        return Carbon::parse($this->fecha_envio)->format('d/m/Y');
    }

    public function getFechaRevisionInfoAttribute()
    {
        return Carbon::parse($this->fecha_revision)->format('d/m/Y');
    }

    public function getNombreEnviaAttribute()
    {
        return User::find($this->envia)->nombre;
    }

    public function getNombreRecibeAttribute()
    {
        return User::find($this->recibe)->nombre;
    }
}
