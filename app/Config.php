<?php

namespace Guia;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $timestamps = false;
    protected $fillable = ['variable','valor','fecha_inicio','fecha_fin'];
}
