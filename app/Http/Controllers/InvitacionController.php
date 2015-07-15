<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Http\Requests;
use Guia\Http\Requests\InvitacionRequest;
use Guia\Classes\Pdfs\InvitacionPdf;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Cotizacion;
use Guia\Models\Benef;
use Guia\Models\Cuadro;
use Illuminate\Http\Request;

class InvitacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($req_id)
	{
		$cotizaciones = Cotizacion::whereReqId($req_id)->get();
        return view('invita.indexInvita', compact('cotizaciones', 'req_id'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($req_id)
	{
        $benefs = Benef::all(array('id','benef'));
        $benefs = $benefs->sortBy('benef');
        foreach($benefs as $benef){
            $arr_benefs[$benef->id] = $benef->benef;
        }

		return view('invita.formInvita')
            ->with('benefs', $arr_benefs)
            ->with('req_id', $req_id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(InvitacionRequest $request)
	{
        //Si existe un cuadro para la requisición, agrega la referencia del ID del cuadro
        $verifica_cuadro = Cuadro::whereReqId($request->input('req_id'))->first();
        if(!empty($verifica_cuadro)){
            $request->merge(array(
                'cuadro_id' => $verifica_cuadro->id
            ));
        }
        $request->merge(array(
            'fecha_invitacion' => Carbon::now()->toDateString()
        ));
		$invitacion = Cotizacion::create($request->all());
        return redirect()->action('InvitacionController@index', array($invitacion->req_id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $invitacion = Cotizacion::findOrFail($id);
        return view('invita.infoInvita')->with('cotizacion', $invitacion);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $benefs = Benef::all(array('id','benef'));
        $benefs = $benefs->sortBy('benef');
        foreach($benefs as $benef){
            $arr_benefs[$benef->id] = $benef->benef;
        }

		$invitacion = Cotizacion::findOrFail($id);
        return view('invita.formInvita')
            ->with('cotizacion', $invitacion)
            ->with('benefs', $arr_benefs)
            ->with('req_id', $invitacion->req_id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, InvitacionRequest $request)
	{
        $invitacion = Cotizacion::findOrFail($id);
        $invitacion->benef_id = $request->input('benef_id');
        $invitacion->fecha_invitacion = $request->input('fecha_invitacion');
        $invitacion->save();

        return redirect()->action('InvitacionController@index', array($invitacion->req_id));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $cotizacion = Cotizacion::findOrFail($id);
        $req_id = $cotizacion->req_id;
        $cotizacion->delete();

        return redirect()->action('InvitacionController@index', array($req_id));
	}

    public function invitacionPdf($id)
    {
        $invitacion = Cotizacion::find($id);
        $articulos = Articulo::whereReqId($invitacion->req_id)->get();
        $invita_pdf = new InvitacionPdf($invitacion, $articulos);

        return response($invita_pdf->crearPdf())->header('Content-Type', 'application/pdf');
    }
}
