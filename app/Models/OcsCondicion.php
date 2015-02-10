<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class OcsCondicion extends Model {

    public $table = 'ocs_condiciones';
    public $timestamps = false;

    //OcsCondicion __belongs_to__ Oc
    public function oc()
    {
        return $this->belongsTo('Guia\Models\Oc');
    }

}
