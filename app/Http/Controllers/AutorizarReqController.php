<?php namespace Guia\Http\Controllers;

use Carbon\Carbon;
use Guia\Classes\ArticulosHelper;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\Models\Articulo;
use Guia\Models\Req;
use Guia\Models\Rm;
use Illuminate\Http\Request;

class AutorizarReqController extends Controller {

	/**
	 * Muestra formulario para autorizar requisición.
	 *
	 * @return Response
	 */
	public function formAutorizar($id)
	{
        $req = Req::find($id);
        $req->fecha_req = Carbon::parse($req->fecha_req)->format('d/m/Y');
        $articulos = Articulo::whereReqId($id)->with('cotizaciones')->with('rms.cog')->get();

        $articulos_helper = new ArticulosHelper($articulos);
        $articulos_helper->setArticulosSinRms();
        $articulos_helper->setRmsArticulos();

        $arr_rms = Rm::whereProyectoId($req->proyecto_id)->get()->lists('cog_rm_saldo', 'id')->all();
        $data['req'] = $req;
        $data['articulos'] = $articulos;
        $data['articulos_sin_rms'] = $articulos_helper->articulos_sin_rms;
        $data['rms_articulos'] = $articulos_helper->rms_articulos;
        $data['arr_rms'] = $arr_rms;

        $rms_asignados = true;
        foreach ($articulos as $articulo) {
            if ($articulo->rms->count() == 0) {
                $rms_asignados = false;
            }
        }
        $data['rms_asignados'] = $rms_asignados;

        return view('reqs.formAutorizarReq')->with($data);
	}

	/**
	 * Actualiza información con la autorización.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function asignarRms(Request $request)
	{
        $rm_id = $request->input('rm_id');
		$arr_articulo_id = $request->input('arr_articulo_id');
        if (! isset($arr_articulo_id) ){
            $arr_articulo_id = array();
        }

        $articulos = Articulo::whereReqId($request->input('req_id'))->get();
        foreach($articulos as $articulo){
            if(array_search($articulo->id, $arr_articulo_id) !== false){
                if($articulo->rms->count() > 0){
                    $articulo->rms()->updateExistingPivot($articulo->rms[0]->id, ['rm_id' => $rm_id, 'monto' => $articulo->monto]);
                } else {
                    $articulo->rms()->attach($rm_id, ['monto' => $articulo->monto]);
                }
                //$articulo->rms()->sync([$rm_id => ['monto' => $articulo->monto_total]]);
            }

            $alta = $request->input('alta_'.$articulo->id);
            isset($alta) ? $inventariable = $request->input('alta_'.$articulo->id) : $inventariable = 0;
            if($articulo->inventariable !== $alta){
                $articulo->inventariable = $alta;
                $articulo->save();
            }
        }

        return redirect()->action('AutorizarReqController@formAutorizar', [$request->input('req_id')]);
	}

	/**
	 * Desautoriza una requisición.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function desautorizar($id)
	{
		//
	}

}
