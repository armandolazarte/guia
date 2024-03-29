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
        $this->req = Req::find($cuadro->req_id);
        $this->getArticulos($cuadro->req_id);
    }

    /**
     * Obtiene los artículos cotizados con información de la cotización
     *
     * @param $req_id
     */
    public function getArticulos($req_id)
    {
        $articulos = Articulo::whereReqId($req_id)
            ->where('no_cotizado', '=', 0)
            ->with(['cotizaciones' => function($query) {
                $query->wherePivot('sel', '=', 1);
            }])
            ->get();
        $this->articulos = $articulos;
    }

    /**
     * Actualiza el monto de cada artículo cotizado en la tabla articulos
     */
    public function setMontoArticulo()
    {
        foreach($this->articulos as $articulo)
        {
            $articulo_x_modificar = Articulo::find($articulo->id);

            if(empty($this->req->tipo_cambio) || $this->req->tipo_cambio == 0){
                $articulo_x_modificar->monto = round( (($articulo->impuesto * 0.01) + 1) * $articulo->cantidad * $articulo->cotizaciones[0]->pivot->costo, 2);
            } else {
                $articulo_x_modificar->monto = round( (($articulo->impuesto * 0.01) + 1) * $articulo->cantidad * $articulo->cotizaciones[0]->pivot->costo * $this->req->tipo_cambio, 2);
            }
            $articulo_x_modificar->save();
        }
    }

    /**
     * Actualiza a 0's el monto de cada artículo cotizado en la tabla articulos
     */
    public function unsetMontoArticulo()
    {
        foreach($this->articulos as $articulo)
        {
            $articulo_x_modificar = Articulo::find($articulo->id);
            $articulo_x_modificar->monto = 0;
            $articulo_x_modificar->save();
        }
    }

    public function estatusReq($estatus)
    {
        $req = Req::find($this->req->id);
        $req->estatus = $estatus;
        $req->save();

        //Creación de registro
        $fecha_hora = Carbon::now();
        $registro = new Registro(['user_id' => \Auth::user()->id, 'estatus' => $estatus, 'fecha_hora' => $fecha_hora]);
        $req->registros()->save($registro);
    }
}