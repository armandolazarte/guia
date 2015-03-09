<?php namespace Guia\Http\Controllers;

use Guia\Models\Accion;
use Guia\Models\Modulo;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AccionesController extends Controller {

    public function index()
    {
        $this->importar_rutas();
        $acciones = Accion::with('modulos')->get();

        return view('admin.su.acciones.index')->with('acciones', $acciones);
    }

    private function importar_rutas()
    {
        //Consulta rutas registradas en tabla acciones
        $arr_rutas = Accion::lists('ruta');
        //Obiene rutas registradas
        $routeCollection = \Route::getRoutes();
        foreach ($routeCollection as $route) {
            $ruta = $route->getPath();
            if ( array_search($ruta, $arr_rutas) === false) {
                //Si no se encuentra el valor de la ruta: Inserta ruta en acciones
                $accion = new Accion;
                $accion->ruta = $ruta;
                $accion->activo = false;
                $accion->save();

                //Agrega ruta nueva a arreglo para no duplicar rutas
                $arr_rutas[] = $ruta;
            }
        }
    }

    public function editar($id)
    {
        $accion = Accion::find($id);
        $modulos = Modulo::all();

        return view('admin.su.acciones.editar')
            ->with('accion', $accion)
            ->with('modulos', $modulos);
    }

    public function actualizar(Request $request, $id)
    {
        $accion = Accion::findOrFail($id);
        $accion->update($request->all());
        $accion->modulos()->sync($request->input('accion_modulo'));

        return redirect()->action('AccionesController@index');
    }
}
