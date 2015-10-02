<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model {

    public $timestamps = false;

    protected $fillable = ['user_id', 'estatus', 'fecha_hora'];
    protected $dates = ['fecha_hora'];

    //Registro __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    public function docable()
    {
        return $this->morphTo();
    }
}
