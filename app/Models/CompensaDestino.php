<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaDestino extends Model {

    protected $fillable = ['compensa_rm_id','rm_id','monto'];

    //CompensaDestino __belongs_to__ CompensaRm
    public function compensaRm()
    {
        return $this->belongsTo('Guia\Models\CompensaRm');
    }

    //CompensaDestino __belongs_to__ Rm
    public function rm()
    {
        return $this->belongsTo('Guia\Models\Rm');
    }

}
