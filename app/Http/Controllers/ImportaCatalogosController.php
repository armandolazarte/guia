<?php namespace Guia\Http\Controllers;

use Guia\Classes\ImportadorCatalogos;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ImportaCatalogosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.su.formImportaCatalogos');
	}

	public function importar(Request $request){
		$db_origen = $request->input('db_origen');
		$catalogo = $request->input('catalogo');
		$importador = new ImportadorCatalogos($db_origen);

		if ($catalogo == "URG"){
			$importador->importarUrgs();
		}
		if ($catalogo == "Fondos"){
			$importador->importarFondos();
		}
		if ($catalogo == "Proyectos"){
			$importador->importarProyectos();
		}
		if ($catalogo == "Cuentas"){
			$importador->importarCuentas();
		}
		if ($catalogo == "Beneficiarios"){
			$importador->importarBenefs();
		}
		if ($catalogo == "COG"){
			$importador->importarCog();
		}

        if ($catalogo == "Usuarios"){
            $importador->importarUsuarios();
        }

		return redirect()->action('ImportaCatalogosController@index');
	}

}
