<?php namespace Guia;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model {

    protected $fillable = ['linkable_id','linkable_type','name','mime','size','created_original','extencion','tipo'];

    public function data_file()
    {
        return $this->hasMany('DataFile');
    }
}
