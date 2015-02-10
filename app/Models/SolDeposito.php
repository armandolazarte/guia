<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class SolDeposito extends Model {

    //SolDeposito __belongs_to__ Fondo
    public function fondo()
    {
        return $this->belongsTo('Guia\Models\Fondo');
    }

    //SolDeposito __has_many__ SolDepositosDoc
    public function solDepositosDocs()
    {
        return $this->hasMany('Guia\Models\SolDepositosDoc');
    }

}
