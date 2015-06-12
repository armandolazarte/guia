<?php namespace Guia\Models;

use Illuminate\Database\Eloquent\Model;

class PreReq extends Model {

	public $timestamps = false;
    protected $fillable = ['sol','fecha','urg_id','etiqueta','lugar_entrega','obs','user_id','justifica','grado','usuario_final','estatus','tipo_orden'];

    //PreReq __belongs_to__ Urg
    public function urg()
    {
        return $this->belongsTo('Guia\Models\Urg');
    }

    //PreReq __belongs_to__ Proyecto
    public function proyecto()
    {
        return $this->belongsTo('Guia\Models\Proyecto');
    }

    //PreReq __belongs_to__ User
    public function user()
    {
        return $this->belongsTo('Guia\User');
    }

    //PreReq __has_many__ PreReqArticulo
    public function preReqArticulos()
    {
        return $this->hasMany('Guia\Models\PreReqArticulo');
    }

}
