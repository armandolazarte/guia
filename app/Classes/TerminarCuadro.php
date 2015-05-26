<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 25/05/2015
 * Time: 11:41 AM
 */

namespace Guia\Classes;

use Carbon\Carbon;
use Guia\Models\Articulo;
use Guia\Models\Cuadro;
use Guia\Models\Req;
use Guia\Models\Registro;

class TerminarCuadro {

    public $articulos;
    public $req;

    public function __construct(Cuadro $cuadro)
    {
        $this->req = Req::find($cuadro->id);
        $this->getArticulos($cuadro->req_id);
    }

    public function getArticulos($req_id)
    {
        $articulos = Articulo::whereReqId($req_id)
            ->with(['cotizaciones' => function($query) {
                $query->wherePivot('sel', '=', 1);
            }])
            ->get();
        $this->articulos = $articulos;
    }

    public function setMontoArticulo()
    {
        foreach($this->articulos as $articulo)
        {
            $articulo_x_modificar = Articulo::find($articulo->id);

            if(empty($this->req->tipo_cambio) || $this->req->tipo_cambio == 0){
                $articulo_x_modificar->monto = (($articulo->impuesto * 0.01) + 1) * $articulo->cantidad * $articulo->cotizaciones[0]->pivot->costo;
            } else {
                $articulo_x_modificar->monto = (($articulo->impuesto * 0.01) + 1) * $articulo->cantidad * $articulo->cotizaciones[0]->pivot->costo * $this->req->tipo_cambio;
            }
            $articulo_x_modificar->save();
        }
    }

    public function estatusReq($estatus)
    {
        $req = Req::find($this->req->id);
        $req->estatus = "Cotizada";
        $req->save();

        //Creación de registro
        $fecha_hora = Carbon::now();
        $registro = new Registro(['user_id' => \Auth::user()->id, 'estatus' => $estatus, 'fecha_hora' => $fecha_hora]);
        $req->registros()->save($registro);
    }
}