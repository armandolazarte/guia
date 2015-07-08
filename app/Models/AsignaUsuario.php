<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaUsuario extends Model
{
    public $timestamps = false;

    public function usuarioAsigna()
    {
        return $this->belongsTo('Guia\User', 'user_id');
    }

}
