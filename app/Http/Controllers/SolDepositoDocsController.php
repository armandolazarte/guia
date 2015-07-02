<?php

namespace Guia\Http\Controllers;

use Guia\Models\Oc;
use Guia\Models\Req;
use Guia\Models\SolDeposito;
use Guia\Models\SolDepositoDoc;
use Guia\Models\Solicitud;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class SolDepositoDocsController extends Controller
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
    public function create($soldep_id)
    {
        $soldep = SolDeposito::findOrFail($soldep_id);
        $fondo_filto = $soldep->fondo_id;

        $solicitudes = array();
        $solicitudes = Solicitud::whereEstatus('Autorizada')->with('proyecto'); // ->with('proyecto.fondos') //Opcional para cargar info sobre proyecto y fondo
        $solicitudes->whereHas('proyecto', function($query) use ($fondo_filto){
            $query->whereHas('fondos', function($fondos_query) use ($fondo_filto) {
               $fondos_query->where('fondo_id', '=', $fondo_filto);
            });
        });
        $solicitudes = $solicitudes->get();

        $reqs = array();
        $reqs = Req::whereEstatus('Autorizada')->with('ocs', 'proyecto');
        $reqs->whereHas('proyecto', function($query) use ($fondo_filto){
            $query->whereHas('fondos', function($fondos_query) use ($fondo_filto) {
                $fondos_query->where('fondo_id', '=', $fondo_filto);
            });
        });

        $reqs = $reqs->get();

        return view('soldep.formSolDepDocs', compact('soldep', 'solicitudes', 'reqs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        return redirect()->action(array('SolDepositoDocsController@create', $request->soldep_id));
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
