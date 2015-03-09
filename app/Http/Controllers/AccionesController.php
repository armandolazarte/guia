<?php namespace Guia\Http\Controllers;

use Guia\Models\Accion;
use Guia\Models\Modulo;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AccionesController extends Controller {

    public function index()
    {
        $acciones = Accion::with('modulos')->get();
        return view('admin.su.acciones.indexAcciones')->with('acciones', $acciones);
    }

    public function create()
    {
        $routeCollection = \Route::getRoutes();
        return view('admin.su.acciones.formImportarRuta', compact('routeCollection'));
    }

    public function store(Request $request)
    {
        //Consulta rutas registradas en tabla acciones
        $acciones = Accion::lists('ruta');
        $arr_rutas = $request->input('arr_rutas');
        foreach($arr_rutas as $ruta){
            if ( array_search($ruta, $acciones) === false) {
                $accion = new Accion;
                $accion->ruta = $ruta;
                $accion->activo = false;
                $accion->save();

                //Agrega ruta nueva a arreglo para no duplicar rutas
                $acciones[] = $ruta;
            }
        }

        return redirect()->action('AccionesController@index')->with(['message' => 'Ruta agregada con éxito']);
    }

    public function edit($id)
    {
        $accion = Accion::find($id);
        $modulos = Modulo::all();

        return view('admin.su.acciones.formEditarAccion')
            ->with('accion', $accion)
            ->with('modulos', $modulos);
    }

    public function update(Request $request, $id)
    {
        $accion = Accion::findOrFail($id);
        $accion->update($request->all());

        $arr_accion_modulo = $request->input('accion_modulo');
        if(count($arr_accion_modulo) == 0) {
            $arr_accion_modulo = [];
        }

        $accion->modulos()->sync($arr_accion_modulo);

        return redirect()->action('AccionesController@index');
    }
}
