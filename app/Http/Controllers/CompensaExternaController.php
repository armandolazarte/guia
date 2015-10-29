<?php

namespace Guia\Http\Controllers;

use Guia\Models\Cog;
use Guia\Models\CompensaDestino;
use Guia\Models\CompensaOrigen;
use Guia\Models\CompensaRm;
use Guia\Models\Proyecto;
use Guia\Models\Rm;
use Guia\Models\UrgExterna;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class CompensaExternaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $compensaciones = CompensaRm::where('tipo', 'Externa')->get();

        return view('compensa.externa.indexCompensaExterna', compact('compensaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $proyectos = \FiltroAcceso::getArrProyectos();
        $cogs = Cog::all();
        $urg_externas = UrgExterna::all()->lists('urg_externa_desc','id')->all();

        return view('compensa.externa.formCompensaExterna', compact('proyectos','cogs','urg_externas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $urg_externa_id = $request->input('urg_externa_id');
        $concepto = $request->input('concepto');
        $tipo_compensa_externa = $request->input('tipo_compensa_externa');
        $proyecto_id = $request->input('proyecto_id');
        $proyecto = Proyecto::find($proyecto_id);
        $proyecto->load('fondos');
        $documento_afin = $request->input('documento_afin');
        if(empty($documento_afin)){
            $documento_afin = 0;
        }
        $fecha = \Carbon\Carbon::now()->toDateString();
        $compensa_rm = CompensaRm::create(['documento_afin' => $documento_afin, 'fecha' => $fecha, 'tipo' => 'Externa']);
        $monto_total = 0;

        if ($request->input('rm_aplicacion') > 0) {
            $j = 0;
            foreach ($request->input('rm_aplicacion') as $rm_aplicacion) {
                $monto_aplicacion = $request->input('monto_aplicacion')[$j];
                if ($monto_aplicacion > 0) {
                    if ($tipo_compensa_externa == 'Ingreso') {
                        CompensaDestino::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm_aplicacion, 'monto' => $monto_aplicacion]);
                    }
                    if ($tipo_compensa_externa == 'Egreso') {
                        CompensaOrigen::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm_aplicacion, 'monto' => $monto_aplicacion]);
                    }
                    $monto_total += $monto_aplicacion;
                }
                $j++;
            }
        }

        if($tipo_compensa_externa == 'Ingreso' && $request->input('monto_nuevo_rm')[0] > 0) {
            $rm_origen_id = $request->input('rm_origen')[0];
            $rmOrigen = Rm::find($rm_origen_id);
            $k = 0;
            foreach ($request->input('rm_nuevo') as $rm_nuevo) {

                $rm = new Rm();
                $rm->rm = $rm_nuevo;
                $rm->proyecto_id = $proyecto_id;
                $rm->objetivo_id = $request->input('objetivo_destino');
                $rm->actividad_id = 1;
                $rm->cog_id = $request->input('cog_nuevo')[$k];
                $rm->fondo_id = $proyecto->fondos[0]->id;
                $rm->monto = 0;
                $rm->d_rm = 'Compensación #' . $compensa_rm->id;
                $rm->save();

                $monto_nuevo_rm = $request->input('monto_nuevo_rm')[$k];
                if ($monto_nuevo_rm > 0) {
                    //Insertar en compsena_destinos
                    CompensaDestino::create(['compensa_rm_id' => $compensa_rm->id, 'rm_id' => $rm->id, 'monto' => $monto_nuevo_rm]);
                    $monto_total += $monto_nuevo_rm;
                }
                $k++;
            }
        }

        $compensa_rm->compensaExternas()->create([
            'urg_externa_id' => $urg_externa_id,
            'concepto' => $concepto,
            'tipo' => $tipo_compensa_externa,
            'monto' => $monto_total
        ]);

        return redirect()->action('CompensaExternaController@index');
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
