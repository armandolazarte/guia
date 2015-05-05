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