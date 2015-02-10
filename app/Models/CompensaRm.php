<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class CompensaRm extends Model {

    //CompensaRm __has_many__ CompensaOrigen
    public function compensaOrigenes()
    {
        return $this->hasMany('Guia\Models\CompensaOrigen');
    }

    //CompensaRm __has_many__ CompensaDestino
    public function compensaDestinos()
    {
        return $this->hasMany('Guia\Models\CompensaDestino');
    }

    //CompensaRm __has_many__ CompensaExterna
    public function compensaExternas()
    {
        return $this->hasMany('Guia\Models\CompensaExterna');
    }

}
