<?php namespace Guia\Classes;

use Guia\Models\Oc;
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
        $sol = Req::orderBy('sol', 'DESC')->first(array('sol'));
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
}