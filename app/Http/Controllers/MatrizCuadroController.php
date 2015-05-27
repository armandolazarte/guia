<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Http\Requests\MatrizCuadroRequest;

use Guia\Models\Articulo;
use Guia\Models\Cotizacion;
use Guia\Models\Cuadro;
use Illuminate\Http\Request;

class MatrizCuadroController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($req_id)
	{
        $cotizaciones = Cotizacion::whereReqId($req_id)->get();
        $articulos = Articulo::whereReqId($req_id)->get();

        return view('cuadro.formMatriz', compact('req_id', 'cotizaciones', 'articulos'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MatrizCuadroRequest $request)
	{
        $req_id = $request->input('req_id');

        //Si existe un cuadro para la requisición, redirecciona para mostrar el cuadro existente
        $verifica_cuadro = Cuadro::whereReqId($req_id);
        if(!empty($verifica_cuadro)){
            return redirect()->action('MatrizCuadroController@show', array($req_id));
        }

        //Crear Cuadro
        $cuadro = new Cuadro();
        $cuadro->req_id = $req_id;
        $cuadro->fecha_cuadro = \Carbon\Carbon::now()->toDateString();
        $cuadro->estatus = 'Cotizando';
        $cuadro->elabora = \Auth::user()->id;
        $cuadro->save();

        //Insertar en articulo_cotizacion
        $arr_articulos_id = Articulo::whereReqId($req_id)->lists('id');
        $arr_cotizaciones_id = Cotizacion::whereReqId($req_id)->lists('id');

        foreach($arr_articulos_id as $articulo_id){
            $articulo = Articulo::find($articulo_id);
            $sel_value = $request->input('sel_'.$articulo_id);

            foreach($arr_cotizaciones_id as $cotizacion_id){
                $costo = $request->input('costo_'.$articulo_id.'_'.$cotizacion_id);
                $sel_value == $cotizacion_id ? $sel = 1 : $sel = 0;

                //Guarda información en tabla pivote articulo_cotizacion
                if($costo > 0){
                    $articulo->cotizaciones()->attach([$cotizacion_id => ['costo' => $costo, 'sel' => $sel]]);
                }
            }

            //Actualizar impuesto en articulos
            $articulo->impuesto = $request->input('impuesto_'.$articulo_id);
            $articulo->save();
        }

        //Actualizar fecha_cotiza en cotizaciones
        foreach($arr_cotizaciones_id as $cotizacion_id) {
            $cotizacion = Cotizacion::find($cotizacion_id);
            $cotizacion->cuadro_id = $cuadro->id;
            $cotizacion->fecha_cotizacion = \Carbon\Carbon::now()->toDateString();
            $cotizacion->vigencia = $request->input('vigencia_'.$cotizacion_id);
            $cotizacion->garantia = $request->input('garantia_'.$cotizacion_id);
            $cotizacion->imprimir = true;
            $cotizacion->save();
        }

        return redirect()->action('MatrizCuadroController@show', array($req_id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($req_id)
	{
        $cotizaciones = Cotizacion::whereReqId($req_id)->get();
        $articulos = Articulo::whereReqId($req_id)->get();
        $cuadro_id = Cuadro::whereReqId($req_id)->pluck('id');

        return view('cuadro.matrizCuadro', compact('req_id', 'cotizaciones', 'articulos', 'cuadro_id'));
	}

	/**
	 * Formulario para editar un cuadro comparativo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $cuadro = Cuadro::find($id);
        $cuadro->load('cotizaciones');
        $cotizaciones = $cuadro->cotizaciones;

        $articulos = Articulo::whereReqId($cuadro->req_id)->get();
        $articulos->load('cotizaciones');

        return view('cuadro.formMatrizEdit', compact('cuadro', 'articulos', 'cotizaciones'));
	}

	/**
	 * Actualiza cuadro comparativo
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, MatrizCuadroRequest $request)
	{
        /**
         * @todo Validar que no se seleccione una cotización de un artículo con costo == 0
         */
        $cuadro = Cuadro::find($id);
        $arr_articulos_id = Articulo::whereReqId($cuadro->req_id)->lists('id');
        $arr_cotizaciones_id = Cotizacion::whereReqId($cuadro->req_id)->lists('id');

        foreach($arr_articulos_id as $articulo_id){
            $articulo = Articulo::find($articulo_id);
            $sel_value = $request->input('sel_'.$articulo_id);

            foreach($arr_cotizaciones_id as $cotizacion_id) {
                $costo_nuevo = $request->input('costo_'.$articulo_id.'_'.$cotizacion_id);
                if(isset($costo_nuevo))
                {
                    $sel_value == $cotizacion_id && $costo_nuevo > 0 ? $sel = 1 : $sel = 0;

                    //Verifica existencia de pivote
                    if($articulo->cotizaciones()->get()->contains($cotizacion_id)){
                        $costo_actual = $articulo->cotizaciones()->whereCotizacionId($cotizacion_id)->first()->pivot->costo;
                        $sel_actual = $articulo->cotizaciones()->whereCotizacionId($cotizacion_id)->first()->pivot->sel;

                        if ($costo_actual != $costo_nuevo || $sel_actual != $sel) {
                            $articulo->cotizaciones()
                                ->updateExistingPivot($cotizacion_id, ['costo' => $costo_nuevo, 'sel' => $sel]);
                        }
                    } else { //Crea un nuevo registro en pivote articulo_cotizacion

                        $articulo->cotizaciones()->attach([$cotizacion_id => ['costo' => $costo_nuevo, 'sel' => $sel]]);
                    }
                }
            }

            //Actualizar impuesto en articulos
            $articulo->impuesto = $request->input('impuesto_'.$articulo_id);
            $articulo->save();
        }

        //Actualiza información de vigencia y garantía @cotizaciones
        foreach($arr_cotizaciones_id as $cotizacion_id) {
            $cotizacion = Cotizacion::find($cotizacion_id);
            $cotizacion->vigencia = $request->input('vigencia_'.$cotizacion_id);
            $cotizacion->garantia = $request->input('garantia_'.$cotizacion_id);
            $cotizacion->imprimir = true;
            $cotizacion->save();
        }

        return redirect()->action('MatrizCuadroController@show', array($cuadro->req_id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
