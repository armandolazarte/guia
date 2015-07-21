<?php

namespace Guia\Http\Controllers;

use Guia\Models\Egreso;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class EgresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $egresos = Egreso::all();
        $egresos->load('benef');
        $egresos->load('rms');
        $egresos->load('cuentaBancaria');
        $egresos->load('user');

        return view('egresos.indexEgresos', compact('egresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $egreso = Egreso::findOrFail($id);

        return view('egresos.formEgreso', compact('egreso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->concepto = $request->input('concepto');
        $egreso->save();

        return redirect()->action('EgresosController@index');
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
