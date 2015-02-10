<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class SolDepositoDoc extends Model {

    //SolDepositosDoc __belongs_to__ SolDeposito
    public function solDeposito()
    {
        return $this->belongsTo('Guia\Models\SolDeposito');
    }

}
