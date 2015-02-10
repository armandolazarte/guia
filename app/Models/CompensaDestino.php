<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaDestino extends Model {

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
