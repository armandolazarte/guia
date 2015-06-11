<?php namespace Guia\Http\Controllers;

use Guia\Http\Requests;
use Guia\Http\Requests\PreReqFormRequest;
use Guia\Http\Controllers\Controller;

use Guia\Models\PreReq;
use Guia\Models\PreReqArticulo;
use Guia\Models\Urg;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PreReqController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $prereqs = PreReq::whereUserId(\Auth::user()->id)->get();
        $prereqs->load('urg');
        return view('prereqs.indexPreReq', compact('prereqs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $urgs = Urg::has('proyectos', '!=', 0)->get();
        return view('prereqs.formPreRequisicion')
            ->with('urgs', $urgs);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PreReqFormRequest $request)
    {
        $prereq = PreReq::create($request->all());

        return redirect()->action('PreReqController@show', array($prereq->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $prereq = PreReq::find($id);
        $prereq->fecha = Carbon::parse($prereq->fecha)->format('d/m/Y');
        $articulos = PreReqArticulo::wherePreReqId($id)->get();
        $data['prereq'] = $prereq;
        if (isset($articulos)) {
            $data['articulos'] = $articulos;
        } else {
            $data['articulos'] = array();
        }
        return view('prereqs.infoPreRequisicion')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $prereq = PreReq::findOrFail($id);

        $urgs = Urg::all(array('id','urg','d_urg'));

        return view('prereqs.formPreRequisicion')
            ->with('prereq', $prereq)
            ->with('urgs', $urgs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, PreReqFormRequest $request)
    {
        $prereq = PreReq::findOrFail($id);

        //Actualización de estatus
        $accion = $request->input('accion');
        if(isset($accion)){

            if($accion == 'Enviar') {
                $estatus = 'Enviada';
            } elseif($accion == 'Recuperar'){
                $estatus = '';
            }

            $prereq->estatus = $estatus;
            $prereq->save();

        //Edición de información
        } else {
            $prereq->urg_id = $request->input('urg_id');
            $prereq->etiqueta = $request->input('etiqueta');
            $prereq->lugar_entrega = $request->input('lugar_entrega');
            $prereq->obs = $request->input('obs');
            $prereq->save();
        }

        return redirect()->action('PreReqController@show', array($prereq->id));
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
