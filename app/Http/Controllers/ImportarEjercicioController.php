<?php

namespace Guia\Http\Controllers;

use Guia\Classes\LegacyRegsImport\ImportarCheques;
use Guia\Classes\LegacyRegsImport\ImportarEgresos;
use Guia\Classes\LegacyRegsImport\ImportarIngresos;
use Guia\Models\CuentaBancaria;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class ImportarEjercicioController extends Controller
{
    public function index()
    {
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta-tipo-urg','id')->all();

        return view('admin.su.formImportarEjercicio', compact('cuentas_bancarias'));
    }

    public function importar(Request $request)
    {
        $db_origen = $request->input('db_origen');
        $col_rango = $request->input('col_rango');
        $cuenta_bancaria_id = $request->input('cuenta_bancaria_id');
        $arr_rango = [$request->input('inicio'), $request->input('fin')];

        if($request->input('registro') == 'Egresos') {
            $importar_egresos = new ImportarEgresos($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id);
            $importar_egresos->importarEgresosLegacy();
        }

        if($request->input('registro') == 'Ingresos') {
            $importar_ingresos = new ImportarIngresos($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id);
            $importar_ingresos->importarIngresosLegacy();
        }

        if($request->input('registro') == 'Cheques') {
            $importar_cheques = new ImportarCheques($db_origen, $col_rango, $arr_rango, $cuenta_bancaria_id);
            $importar_cheques->importarChequesLegacy();
        }

        return redirect()->action('ImportarEjercicioController@index')
            ->with(['message' => 'Importación exitosa']);
    }
}
