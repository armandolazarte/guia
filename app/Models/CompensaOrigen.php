<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaOrigen extends Model {

    public $table = 'compensa_origenes';

    //CompensaOrigen __belongs_to__ CompensaRm
    public function compensaRm()
    {
        return $this->belongsTo('Guia\Models\CompensaRm');
    }

    //CompensaOrigen __belongs_to__ Rm
    public function rm()
    {
        return $this->belongsTo('Guia\Models\Rm');
    }

}
