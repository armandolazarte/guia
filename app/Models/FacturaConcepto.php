<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaConcepto extends Model {

    public $timestamps = false;

    //FacturaConcepto __belongs_to__ Factura
    public function factura()
    {
        return $this->belongsTo('Guia\Models\Factura');
    }

    //FacturaConcepto __belongs_to__ Rm
    public function rm()
    {
        return $this->belongsTo('Guia\Models\Rm');
    }

    //FacturaConcepto __belongs_to__ Cog
    public function cog()
    {
        return $this->belongsTo('Guia\Models\Cog');
    }

}
