<?php

namespace Guia\Http\Controllers;

use Guia\Classes\LegacyRegsImport\ActualizarImpuesto;
use Guia\Classes\LegacyRegsImport\ImportarArticulos;
use Guia\Classes\LegacyRegsImport\ImportarCompensa;
use Guia\Classes\LegacyRegsImport\ImportarComprobaciones;
use Guia\Classes\LegacyRegsImport\ImportarInvitaciones;
use Guia\Classes\LegacyRegsImport\ImportarOcs;
use Guia\Classes\LegacyRegsImport\ImportarReqs;
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
            $importa_req = new ImportarReqs($db_origen, $col_rango, $arr_rango);
            $importa_req->importarReqs();
        }

        if($request->input('registro') == 'OCs') {
            $importa_oc = new ImportarOcs($db_origen, $col_rango, $arr_rango);
            $importa_oc->importarOcs();
        }

        if($request->input('registro') == 'Condiciones') {
            $importa_oc = new ImportarOcs($db_origen, $col_rango, $arr_rango);
            $importa_oc->actualizarCondiciones();
        }

        if($request->input('registro') == 'Articulos') {
            $importa_oc = new ImportarArticulos($db_origen, $col_rango, $arr_rango);
            $importa_oc->importarArticulos();
        }

        if($request->input('registro') == 'Invitaciones') {
            $importa_invita = new ImportarInvitaciones($db_origen, $col_rango, $arr_rango);
            $importa_invita->importarInvitaciones();
        }

        if($request->input('registro') == 'ActualizarFechaCuadro') {
            $importa_invita = new ImportarInvitaciones($db_origen, $col_rango, $arr_rango);
            $importa_invita->actualizarFechaCuadro();
        }

        if($request->input('registro') == 'Compensaciones') {
            $importa_compensa = new ImportarCompensa($db_origen);
            $importa_compensa->importarCompensaciones();
        }

        if($request->input('registro') == 'ActualizarImpuesto') {
            $actualizar_impuesto = new ActualizarImpuesto($db_origen);
            $actualizar_impuesto->actualizarImpuesto();
        }

        if($request->input('registro') == 'Comprobaciones') {
            $importar_comprobaciones = new ImportarComprobaciones($db_origen, $col_rango, $arr_rango);
            $importar_comprobaciones->importarComps();
        }

        return redirect()->action('ImportarRegistrosController@index')
            ->with(['message' => 'Importación de registros exitosa']);
    }
}
