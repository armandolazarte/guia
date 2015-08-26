<?php

namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public $timestamps = false;
    protected $fillable = ['grupo','tipo'];

    //Grupo __belongs_to_many__ User
    public function users()
    {
        return $this->belongsToMany('Guia\User')->withPivot('supervisa','administra');
    }
}
