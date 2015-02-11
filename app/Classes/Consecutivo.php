<?php namespace Guia\Classes;

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
}