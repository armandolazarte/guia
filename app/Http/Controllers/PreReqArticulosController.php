<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Requests\PreReqArticuloFormRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\PreReq;
use Guia\Models\PreReqArticulo;
use Guia\Models\Unidad;
use Illuminate\Http\Request;

class PreReqArticulosController extends Controller {

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
    public function create($prereq_id)
    {
        $prereq = PreReq::find($prereq_id);
        $unidades = Unidad::all();
        $data['prereq'] = $prereq;

        foreach($unidades as $unidad){
            $arr_unidades[$unidad->tipo][$unidad->unidad] = $unidad->unidad;
        }
        $data['unidades'] = $arr_unidades;

        return view('prereqs.formPreReqArticulo')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PreReqArticuloFormRequest $request)
    {
        $articulo = new PreReqArticulo();
        $articulo->pre_req_id = $request->input('prereq_id');
        $articulo->articulo = $request->input('articulo');
        $articulo->cantidad = $request->input('cantidad');
        $articulo->unidad = $request->input('unidad');
        $articulo->save();

        return redirect()->action('PreReqController@show', array($request->input('prereq_id')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $prereq_id
     * @param  int  $articulo_id
     * @return Response
     */
    public function edit($prereq_id, $articulo_id)
    {
        $articulo = PreReqArticulo::find($articulo_id);

        //Verifica que el artículo corresponda a la requisición
        if ($articulo->pre_req_id == $prereq_id)
        {
            $unidades = Unidad::all();
            foreach($unidades as $unidad){
                $arr_unidades[$unidad->tipo][$unidad->unidad] = $unidad->unidad;
            }

            $data['articulo'] = $articulo;
            $data['prereq'] = $articulo->prereq;
            $data['unidades'] = $arr_unidades;

            return view('prereqs.formPreReqArticulo')->with($data);
        } else {
            return redirect()->action('PreReqController@show', array($prereq_id))->with(['alert-class' => 'alert-warning', 'message' => 'El artículo no corresponde a la solicitud']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(PreReqArticuloFormRequest $request, $id)
    {
        $articulo = PreReqArticulo::findOrFail($id);
        $articulo->articulo = $request->input('articulo');
        $articulo->cantidad = $request->input('cantidad');
        $articulo->unidad =$request->input('unidad');
        $articulo->save();

        return redirect()->action('PreReqController@show', array($articulo->prereq->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $articulo = PreReqArticulo::findOrFail($id);
        $prereq_id = $articulo->prereq->id;
        $articulo->delete();
        return redirect()->action('PreReqController@show', array($prereq_id));
    }

}
