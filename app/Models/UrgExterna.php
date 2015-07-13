<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class UrgExterna extends Model {

    protected $fillable = ['urg_externa','d_urg_externa'];

    //UrgExterna __has_many__ CompensaExterna
    public function compensaExterna()
    {
        return $this->hasMany('Guia\Models\CompensaExterna');
    }

}
