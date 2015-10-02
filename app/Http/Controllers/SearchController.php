<?php

namespace Guia\Http\Controllers;

use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function buscarDocumento(Request $request)
    {
        $tipo_documento = $request->input('tipo_documento');
        $no_documento = $request->input('no_documento');

        if (empty($tipo_documento) || empty($no_documento)) {
            return redirect()->back()->with(['message' => 'Debe indicar el No. de Documento a Buscar']);
        }

        if ($tipo_documento == 'Solicitud') {
            return redirect()->action('SolicitudController@show', $no_documento);
        }
    }
}
