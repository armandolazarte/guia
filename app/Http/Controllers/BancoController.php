<?php

namespace Guia\Http\Controllers;

use Guia\Models\Benef;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class BancoController extends Controller
{
    public function reporteEgresosBenef()
    {
        return view('egresos.reporteEgresosBenef');
    }
}
