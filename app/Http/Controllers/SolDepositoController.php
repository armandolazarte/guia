<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\Fondo;
use Guia\Models\SolDeposito;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class SolDepositoController extends Controller
{
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
    public function create()
    {
        $fondos = Fondo::fondosProyectosActivos()->get()->lists('fondo_desc', 'id');
        return view('soldep.formSolDep', compact('fondos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Requests\SolDepositoRequest $request)
    {
        $request->merge(array(
            'fecha' => Carbon::now()->toDateString()
        ));
        $soldep = SolDeposito::create($request->all());

        return redirect()->action('SolDepositoDocsController@create', $soldep->id);
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
