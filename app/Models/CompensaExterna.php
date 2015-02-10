<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaExterna extends Model {

    //CompensaExterna __belongs_to__ CompensaRm
    public function compensaRm()
    {
        return $this->belongsTo('Guia\Models\CompensaRm');
    }

    //CompensaExterna __belongs_to__ UrgExterna
    public function urgExterna()
    {
        return $this->belongsTo('Guia\Models\UrgExterna');
    }

}
