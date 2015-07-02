<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class SolDepositosDoc extends Model {

    //SolDepositosDoc __belongs_to__ SolDeposito
    public function solDeposito()
    {
        return $this->belongsTo('Guia\Models\SolDeposito');
    }

    //SolDepositosDoc __morph_to__ Solicitud|Oc
    public function doc()
    {
        return $this->morphTo();
    }
}
