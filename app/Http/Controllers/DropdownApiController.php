<?php

namespace Guia\Http\Controllers;

use Guia\Models\Objetivo;
use Guia\Models\Rm;
use Illuminate\Http\Request;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class DropdownApiController extends Controller
{
    public function objetivos($proyecto_id) {
        $objetivos = Objetivo::where('proyecto_id', $proyecto_id)
            ->get();
        return response()->json($objetivos);
    }

    public function rms($proyecto_id) {
        $rms = Rm::where('proyecto_id', $proyecto_id)->get(['rm','id']);
        return response()->json($rms);
    }

}
