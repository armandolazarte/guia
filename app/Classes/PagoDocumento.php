<?php
/**
 * Created by PhpStorm.
 * User: Samuel Mercado
 * Date: 23/09/2015
 * Time: 12:33 PM
 */

namespace Guia\Classes;


use Guia\Models\Egreso;
use Guia\Models\Oc;
use Guia\Models\Req;
use Guia\Models\Solicitud;

class PagoDocumento
{
    public $documento;
    public $tipo; // [Solicitud || Oc]

    public function __construct($documento = null, $tipo = null)
    {
        $this->documento = $documento;
        $this->tipo = $tipo;
    }

    public function pagarDocumento(Egreso $egreso)
    {
        if (!is_null($this->documento) && !is_null($this->tipo)) {
            /**
             * @todo Determinar si el pago es total o parcial
             */
            $this->actualizarEstatusDoc('Pagada');
            $this->relacionarPagoEgreso($egreso);

            if ($this->tipo == 'Oc') {
                $this->actualizarEstatusReq($this->documento->req_id);
            }
        }
    }

    public function cancelarPago(Egreso $egreso)
    {
        if (count($egreso->solicitudes) > 0) {
            $egreso->solicitudes()->update(['estatus' => 'Autorizada']);
        } elseif (count($egreso->ocs) > 0) {
            $egreso->ocs()->update(['estatus' => '']);
            $this->actualizarEstatusReq($egreso->ocs[0]->req_id);
        }
    }

    private function actualizarEstatusReq($req_id)
    {
        $ocs = Oc::where('req_id', $req_id)->get();
        $estatus_req = 'Pagada';
        foreach ($ocs as $oc) {
            if ($oc->estatus != 'Pagada') {
                $estatus_req = 'Autorizada';
            }
        }

        $req = Req::find($req_id);
        if ($req->estatus != $estatus_req) {
            $req->estatus = $estatus_req;
            $req->save();
        }
    }

    private function actualizarEstatusDoc($estatus)
    {
        $this->documento->estatus = $estatus;
        $this->documento->save();
    }

    private function relacionarPagoEgreso(Egreso $egreso)
    {
        $this->documento->egresos()->save($egreso);
    }
}
