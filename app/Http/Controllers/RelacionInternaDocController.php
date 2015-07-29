<?php

namespace Guia\Http\Controllers;

use Guia\Models\Egreso;
use Guia\Models\RelInterna;
use Guia\Models\RelInternaDoc;
use Illuminate\Http\Request;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

class RelacionInternaDocController extends Controller
{
    /**
     * Lista los documentos para agregar a relación.
     *
     * @return Response
     */
    public function create($rel_interna_id)
    {
        $rel_interna = RelInterna::findOrFail($rel_interna_id);

        if ($rel_interna->tipo_documentos == 'Egresos') {
            /**
             * @todo Filtrar egresos que no estén en relaciones en tránsito
             * @todo Filtrar egresos por grupo de usuarios
             */

            $documentos = Egreso::whereUserId(\Auth::user()->id)->get();
            //$documentos = Egreso::all();//Only for testing

            $documentos->load('benef');
            $documentos->load('cuentaBancaria');
        }

        return view('relint.formRelInternaDoc', compact('rel_interna', 'documentos'));
    }

    /**
     * Guarda el documento en la relación interna.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rel_interna_docs = RelInternaDoc::create([
            'rel_interna_id' => $request->input('rel_interna_id')
        ]);

        if ($request->input('doc_type') == 'Egreso') {
            $doc = Egreso::find($request->input('doc_id'));
            $ocultar_id = 'egreso-'.$request->input('doc_id');
            $message = "Egreso ".$request->input('doc_id').' agregado';
        }

        $doc->relacionInternaDocs()->save($rel_interna_docs);

        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
                'ocultar' => $ocultar_id
            ]);
        }
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
