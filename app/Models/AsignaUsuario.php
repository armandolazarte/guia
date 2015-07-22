<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaUsuario extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id','asignado_user_id'];

    public function usuarioAsigna()
    {
        return $this->belongsTo('Guia\User', 'user_id');
    }

}
