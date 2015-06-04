<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class OcsCondicion extends Model {

    public $table = 'ocs_condiciones';
    public $timestamps = false;

    protected $fillable = ['forma_pago','fecha_entrega','pago','no_parcialidades','porcentaje_anticipo','fecha_inicio','fecha_conclucsion','fianzas','obs'];

    //OcsCondicion __belongs_to__ Oc
    public function oc()
    {
        return $this->belongsTo('Guia\Models\Oc');
    }

}
