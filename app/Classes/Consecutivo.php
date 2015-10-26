<?php namespace Guia\Classes;

use Guia\Models\Egreso;
use Guia\Models\Oc;
use Guia\Models\PreReq;
use Guia\Models\Req;

class Consecutivo {

    public function nextReq()
    {
        $req = Req::orderBy('req', 'DESC')->first(array('req'));
        if(isset($req)){
            $req->req ++;
            return $req->req;
        } else {
            return 1;
        }
    }

    public function nextPreReq()
    {
        $sol = PreReq::orderBy('sol', 'DESC')->first(array('sol'));
        if(isset($sol)){
            $sol->sol ++;
            return $sol->sol;
        } else {
            return 1;
        }
    }

    public function nextOc()
    {
        $oc = Oc::orderBy('oc', 'DESC')->first(['oc']);
        if(isset($oc)){
            $oc->oc ++;
            return $oc->oc;
        } else {
            return 1;
        }
    }

    public function nextCheque()
    {
        $egreso = Egreso::orderBy('cheque', 'DESC')->first(array('cheque'));
        if(isset($egreso)){
            $egreso->cheque ++;
            return $egreso->cheque;
        } else {
            return env('CHEQUE_INICIAL', 1);
        }
    }

    public function nextPolizaEgreso($cuenta_bancaria_id)
    {
        $egreso = Egreso::where('cuenta_bancaria_id', $cuenta_bancaria_id)->orderBy('poliza', 'DESC')->first(array('poliza'));
        if(isset($egreso)){
            $egreso->poliza ++;
            return $egreso->poliza;
        } else {
            return env('POLIZA_EGRESO_INICIAL', 1);
        }
    }

}
