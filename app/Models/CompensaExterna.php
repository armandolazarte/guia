<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaExterna extends Model {

    protected $fillable = ['compensa_rm_id','urg_externa_id','concepto','tipo','monto'];

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
