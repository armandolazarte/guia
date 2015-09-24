<?php

namespace Guia\Http\Controllers;

use Guia\Models\CuentaBancaria;
use Guia\Models\NoIdentificado;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class NoIdentificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /**
         * @todo Determinar Cuentas bancarias accesibles por el usuario y seleccionar en default la primera
         */

        $cuenta_bancaria_id = $request->get('cuenta_bancaria_id');
        if (empty($cuenta_bancaria_id)) {
            $cuenta_bancaria_id = 1;
        }

        $no_identificados = NoIdentificado::where('cuenta_bancaria_id', $cuenta_bancaria_id)->with('cuentaBancaria')->get();
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id')->all();

        return view('no_identificados.indexNoIdentificados', compact('no_identificados','cuentas_bancarias','cuenta_bancaria_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id')->all();

        return view('no_identificados.formNoIdentificado', compact('cuentas_bancarias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\NoIdentificadoRequest $request)
    {
        $no_identificado = NoIdentificado::create($request->all());

        return redirect()->action('NoIdentificadoController@show', $no_identificado->cuenta_bancaria_id)->with([
            'message' => 'Depósito No Identificado creado con éxito',
            'alert-class' => 'alert-success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $no_identificado = NoIdentificado::findOrFail($id);

        return view('no_identificados.infoNoIdentificado', compact('no_identificado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $no_identificado = NoIdentificado::findOrFail($id);
        $cuentas_bancarias = CuentaBancaria::all()->lists('cuenta_tipo_urg','id')->all();

        return view('no_identificados.formNoIdentificado', compact('no_identificado','cuentas_bancarias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Requests\NoIdentificadoRequest $request)
    {
        NoIdentificado::findOrFail($id)->update($request->all());

        return redirect()->action('NoIdentificadoController@show', $id)->with([
            'message' => 'Depósito no identificado actualizado con éxito',
            'alert-class' => 'alert-info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $no_identificado = NoIdentificado::findOrFail($id);
        if ($no_identificado->identificado == 1) {
            return redirect()->back()->with([
                'message' => 'El depósito ya ha sido identificado por lo que no puede ser eliminado',
                'alert-class' => 'alert-warning'
            ]);
        }
        $no_identificado->delete();

        return redirect()->action('NoIdentificadoController@index')->with([
            'message' => 'Depósito eliminado con éxito',
            'alert-class' => 'alert-success'
        ]);
    }
}
