<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class UrgExterna extends Model {

    //UrgExterna __has_many__ CompensaExterna
    public function compensaExterna()
    {
        return $this->hasMany('Guia\Models\CompensaExterna');
    }

}
