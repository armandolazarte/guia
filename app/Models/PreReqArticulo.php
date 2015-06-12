<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class PreReqArticulo extends Model {

    public $timestamps = false;
    protected $fillable = ['articulo','cantidad','unidad'];

    //PreReqArticulo __belongs_to__ PreReq
    public function preReq()
    {
        return $this->belongsTo('Guia\Models\PreReq');
    }

    //PreReqArticulo __belongs_to__ Req
    public function req()
    {
        return $this->belongsTo('Guia\Models\Req');
    }

}
