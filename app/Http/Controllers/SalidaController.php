<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Almacen\Entrada;
use Guia\Models\Almacen\Salida;
use Guia\Models\Urg;
use Illuminate\Http\Request;

class SalidaController extends Controller {

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
	public function create($entrada_id)
	{
		$entradas = Entrada::find($entrada_id);
        $entradas->load('articulos');
        $urgs = Urg::all(array('id','urg','d_urg'));
        return view('almacen.salida.formArticulos', compact('entradas','urgs'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Requests\SalidaRequest $request)
	{
        $request->merge(array('responsable' => \Auth::user()->id));
        $request->merge(array('fecha_salida' => \Carbon\Carbon::now()->toDateString()));

        $salida = Salida::create($request->all());

        //Crear articulo_salida
        foreach($request->input('arr_articulo_id') as $art){
            $cantidad = $request->input('cantidad_'.$art);
            if($cantidad > 0){
                $salida->articulos()->attach($art, ['cantidad' => $cantidad]);
            }
        }

        return redirect()->action('SalidaController@show', [$salida->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$salida = Salida::find($id);
        return view('almacen.salida.showSalida', compact('salida'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
