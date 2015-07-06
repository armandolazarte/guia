<?php

namespace Guia\Http\Controllers;

use Guia\Classes\LegacyRegsImport\ImportarSolicitudes;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class ImportarRegistrosController extends Controller
{
    public function index()
    {
        return view('admin.su.formImportarRegistros');
    }

    public function importar(Request $request)
    {
        $db_origen = $request->input('db_origen');
        $col_rango = $request->input('col_rango');
        $arr_rango = [$request->input('inicio'), $request->input('fin')];

        if($request->input('registro') == 'Solicitudes') {
            $importa_sol = new ImportarSolicitudes($db_origen, $col_rango, $arr_rango);
            $importa_sol->importarSolicitudes();
        }

        if($request->input('registro') == 'Requisiciones') {

        }

        return redirect()->action('ImportarRegistrosController@index');
    }
}
