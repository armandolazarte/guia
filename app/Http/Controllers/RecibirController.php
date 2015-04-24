<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Http\Requests;
use Guia\Http\Requests\RecibirRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\Req;
use Guia\Models\Solicitud;
use Guia\Models\Registro;
use Illuminate\Http\Request;

class RecibirController extends Controller {

    public function seleccionarSol()
    {
        $solicitudes = Solicitud::whereEstatus('Enviada')->get();
        $solicitudes->load('urg');
        return view('solicitudes.formRecibirSol', compact('solicitudes'));
    }

    public function seleccionarReq()
    {
        $reqs = Req::whereEstatus('Enviada')->get();
        $reqs->load('urg');
        return view('reqs.formRecibirReq', compact('reqs'));
    }

	public function recibirSol(RecibirRequest $request)
    {
        foreach($request->input('arr_sol_id') as $sol_id){
            $solicitud = Solicitud::find($sol_id);
            $solicitud->estatus = $request->input('estatus');
            $solicitud->responsable = \Auth::user()->id;
            $solicitud->save();

            //Creación de registro
            $fecha_hora = Carbon::now();
            $registro = new Registro(['user_id' => \Auth::user()->id, 'estatus' => $request->input('estatus'), 'fecha_hora' => $fecha_hora]);
            $solicitud->registros()->save($registro);
        }

        return redirect()->action('RecibirController@seleccionarSol')->with(['message' => 'Solicitudes recibidas', 'alert-class' => 'alert-success']);
    }

    public function recibirReq(RecibirRequest $request)
    {
        foreach($request->input('arr_req_id') as $req_id){
            $requisicion = Req::find($req_id);
            $requisicion->estatus = $request->input('estatus');
            $requisicion->responsable = \Auth::user()->id;
            $requisicion->save();

            //Creación de registro
            $fecha_hora = Carbon::now();
            $registro = new Registro(['user_id' => \Auth::user()->id, 'estatus' => $request->input('estatus'), 'fecha_hora' => $fecha_hora]);
            $requisicion->registros()->save($registro);
        }

        return redirect()->action('RecibirController@seleccionarReq')->with(['message' => 'Requisiciones recibidas', 'alert-class' => 'alert-success']);
    }

}
