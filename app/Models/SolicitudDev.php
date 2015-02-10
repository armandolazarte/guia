<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDev extends Model {

    //SolicitudDev __belongs_to__ Solicitud
    public function solicitud()
    {
        return $this->belongsTo('Guia\Models\Solicitud');
    }

}
