<?php

namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Models\RelInterna;
use Guia\User;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class RelacionInternaController extends Controller
{
    /**
     * Lista relaciones internas.
     *
     * @return Response
     */
    public function index()
    {
        $rel_internas = RelInterna::where('envia', \Auth::user()->id)
            ->orWhere('recibe', \Auth::user()->id)->get();

        return view('relint.indexRelInterna', compact('rel_internas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rel_interna = RelInterna::create([
            'envia' => \Auth::user()->id,
            'estatus' => '',
            'tipo_documentos' => $request->input('tipo_documentos')
        ]);

        return redirect()->action('RelacionInternaDocController@create', $rel_interna->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $rel_interna = RelInterna::findOrFail($id);
        $arr_usuarios = User::all()->sortBy('nombre')->lists('nombre', 'id')->all();

        return view('relint.infoRelInterna', compact('rel_interna', 'arr_usuarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $rel_interna = RelInterna::findOrFail($id)->with('relInternaDocs');

        return view('relint.formRelInt', compact('rel_interna'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

        if ($request->input('accion') == 'Enviar') {
            $rel_interna = RelInterna::findOrFail($id);
            $rel_interna->fecha_envio = Carbon::today()->toDateString();
            $rel_interna->recibe = $request->input('recibe');
            $rel_interna->estatus = 'Enviada';
            $rel_interna->save();
            $message = 'Relación '.$rel_interna->id.' enviada con éxito';
        }

        return redirect()->action('RelacionInternaController@index')
            ->with(['message' => $message]);
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
