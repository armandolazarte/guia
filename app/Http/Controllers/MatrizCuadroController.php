<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Http\Requests\MatrizCuadroRequest;

use Guia\Models\Articulo;
use Guia\Models\Cotizacion;
use Guia\Models\Cuadro;
use Guia\Models\Oc;
use Guia\Models\Registro;
use Guia\Models\Req;
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
        //Si existe un cuadro para la requisición, redirecciona para mostrar el cuadro existente
        $verifica_cuadro = Cuadro::whereReqId($req_id)->first();
        if(!empty($verifica_cuadro)){
            if (empty($verifica_cuadro->estatus) || $verifica_cuadro->estatus == 'Cotizando') {
                return redirect()->action('MatrizCuadroController@edit', array($verifica_cuadro->id));
            } elseif ($verifica_cuadro->estatus == 'Terminado') {
                return redirect()->action('MatrizCuadroController@show', array($req_id));
            }
        }

        $cotizaciones = Cotizacion::whereReqId($req_id)->get();
        $articulos = Articulo::whereReqId($req_id)->get();
        $iva = \Utility::iva();

        return view('cuadro.formMatriz', compact('req_id', 'cotizaciones', 'articulos', 'iva'));
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
        $verifica_cuadro = Cuadro::whereReqId($req_id)->first();
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
        $arr_articulos_id = Articulo::whereReqId($req_id)->lists('id')->all();
        $arr_cotizaciones_id = Cotizacion::whereReqId($req_id)->lists('id')->all();

        foreach($arr_articulos_id as $articulo_id){
            $articulo = Articulo::find($articulo_id);
            $sel_value = $request->input('sel_'.$articulo_id);
            $no_cotizado = $request->input('no_cotizado_'.$articulo_id);
            if (empty($no_cotizado)) {
                $no_cotizado = 0;
            }

            foreach($arr_cotizaciones_id as $cotizacion_id){
                $costo = $request->input('costo_'.$articulo_id.'_'.$cotizacion_id);
                $sel_value == $cotizacion_id && empty($no_cotizado) ? $sel = 1 : $sel = 0;

                //Guarda información en tabla pivote articulo_cotizacion
                $articulo->cotizaciones()->attach([$cotizacion_id => ['costo' => round($costo,2), 'sel' => $sel]]);
            }

            //Actualizar impuesto y no_cotizado en articulos
            $articulo->impuesto = $request->input('impuesto_'.$articulo_id);
            $articulo->no_cotizado = $request->input('no_cotizado_'.$articulo_id);
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

        //Actualización de tipo de cambio
        $tipo_cambio = $request->input('tipo_cambio');
        $moneda = $request->input('moneda');
        if (!empty($tipo_cambio) && !empty($moneda)) {
            $req = Req::find($req_id);
            $req->tipo_cambio = $tipo_cambio;
            $req->moneda = $moneda;
            $req->save();
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

        $req = Req::whereId($req_id)->first(['tipo_cambio','moneda','estatus']);

        $ocs = Oc::whereReqId($req_id)->with('benef')->get();
        return view('cuadro.matrizCuadro', compact('req_id', 'cotizaciones', 'articulos', 'cuadro_id', 'req','ocs'));
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

        $req = Req::whereId($cuadro->req_id)->first(['tipo_cambio','moneda']);
        $tipo_cambio = $req->tipo_cambio;
        $moneda = $req->moneda;

        return view('cuadro.formMatrizEdit', compact('cuadro', 'articulos', 'cotizaciones', 'tipo_cambio','moneda'));
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
        $arr_articulos_id = Articulo::whereReqId($cuadro->req_id)->lists('id')->all();
        $arr_cotizaciones_id = Cotizacion::whereReqId($cuadro->req_id)->lists('id')->all();

        foreach($arr_articulos_id as $articulo_id){
            $articulo = Articulo::find($articulo_id);
            $sel_value = $request->input('sel_'.$articulo_id);
            $no_cotizado = $request->input('no_cotizado_'.$articulo_id);
            if (empty($no_cotizado)) {
                $no_cotizado = 0;
            }

            foreach($arr_cotizaciones_id as $cotizacion_id) {
                $costo_nuevo = $request->input('costo_'.$articulo_id.'_'.$cotizacion_id);
                if(isset($costo_nuevo))
                {
                    $sel_value == $cotizacion_id && $costo_nuevo > 0 && empty($no_cotizado) ? $sel = 1 : $sel = 0;

                    //Verifica existencia de pivote
                    if($articulo->cotizaciones()->get()->contains($cotizacion_id)){
                        $costo_actual = $articulo->cotizaciones()->whereCotizacionId($cotizacion_id)->first()->pivot->costo;
                        $sel_actual = $articulo->cotizaciones()->whereCotizacionId($cotizacion_id)->first()->pivot->sel;

                        if ($costo_actual != $costo_nuevo || $sel_actual != $sel) {
                            $articulo->cotizaciones()
                                ->updateExistingPivot($cotizacion_id, ['costo' => round($costo_nuevo,2), 'sel' => $sel]);
                        }
                    } else { //Crea un nuevo registro en pivote articulo_cotizacion

                        $articulo->cotizaciones()->attach([$cotizacion_id => ['costo' => round($costo_nuevo,2), 'sel' => $sel]]);
                    }
                }
            }

            //Actualizar impuesto en articulos
            $articulo->impuesto = $request->input('impuesto_'.$articulo_id);
            $articulo->no_cotizado = $no_cotizado;
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

        //Actualizar Tipo de Cambio en @reqs
        $tipo_cambio = $request->input('tipo_cambio');
        $moneda = $request->input('moneda');
        $req = Req::find($cuadro->req_id);
        if($req->tipo_cambio != $tipo_cambio || $req->moneda != $moneda) {
            $req->tipo_cambio = $tipo_cambio;
            $req->moneda = $moneda;
            $req->save();
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
