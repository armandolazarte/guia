<?php namespace Guia;

use Illuminate\Database\Eloquent\Model;

class DataFile extends Model {

    public $timestamps = false;
    protected $fillable = ['archivo_id','chunk_id','data'];

    public function archivo()
    {
        return $this->belongsTo('Guia\Archivo');
    }
}
