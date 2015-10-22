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

    public function pagarDocumento(Egreso $egreso, $tipo_pago)
    {
        if (!is_null($this->documento) && !is_null($this->tipo)) {

            switch ($tipo_pago) {
                case 'Total':
                case 'Finiquito':
                    $estatus = 'Pagada';
                    break;
                case 'Parcial':
                    $estatus = 'Pago Parcial';
                    break;
                case 'Reintegro Total':
                    $this->tipo == 'Solicitud' ? $estatus = 'Autorizada' : $estatus = '';
                    break;
                case 'Reintegro Parcial':
                    $estatus = $egreso->estatus;//Sin cambio
                    break;
            }

            $this->actualizarEstatusDoc($estatus);
            $this->relacionarPagoEgreso($egreso);

            if ($this->tipo == 'Oc') {
                $this->actualizarEstatusReq($this->documento->req_id);
            }
        }
    }

    public function cancelarPago(Egreso $egreso)
    {
        if (count($egreso->solicitudes) > 0) {

            $estatus = 'Autorizada';
            //Verifica si existen más de un egreso de  la solicitud, para en su caso el estatus sea "Pago Parcial"
            foreach ($egreso->solicitudes as $solicitud) {
                $sol_verifica = Solicitud::find($solicitud->id)->load('egresos');
                if (count($sol_verifica->egresos) > 1) {
                    $estatus = 'Pago Parcial';
                } else {
                    $estatus = 'Autorizada';
                }
            }

            $egreso->solicitudes()->update(['estatus' => $estatus]);
        } elseif (count($egreso->ocs) > 0) {

            $estatus = '';
            //Verifica si existe más de un egreso de la Oc, para en su caso el estatus sea "Pago Parcial;
            foreach ($egreso->ocs as $oc) {
                $oc_verifica = Oc::find($oc->id)->load('egresos');
                if (coun($oc_verifica->egresos) > 1) {
                    $estatus = 'Pago Parcial';
                } else {
                    $estatus = '';
                }
            }

            $egreso->ocs()->update(['estatus' => $estatus]);
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
