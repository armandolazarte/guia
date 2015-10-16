<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class UrgExterna extends Model {

    public $timestamps = false;
    protected $fillable = ['urg_externa','d_urg_externa'];

    //UrgExterna __has_many__ CompensaExterna
    public function compensaExterna()
    {
        return $this->hasMany('Guia\Models\CompensaExterna');
    }

    /**
     * Concatena los atributos urg_externa y d_urg_externa
     *
     * @return string
     */
    public function getUrgExternaDescAttribute()
    {
        return $this->urg_externa.' - '.$this->d_urg_externa;
    }
}
