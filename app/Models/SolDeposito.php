<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class SolDeposito extends Model {

    protected $fillable = ['fecha_deposito', 'estatus', 'fondo_id', 'afin_soldep', 't_banco', 'obs'];

    //SolDeposito __belongs_to__ Fondo
    public function fondo()
    {
        return $this->belongsTo('Guia\Models\Fondo');
    }

    //SolDeposito __belongs_to__ Ingreso
    public function ingreso()
    {
        return $this->belongsTo('Guia\Models\Ingreso');
    }

    //SolDeposito __has_many__ SolDepositosDoc
    public function solDepositosDocs()
    {
        return $this->hasMany('Guia\Models\SolDepositosDoc');
    }

}
