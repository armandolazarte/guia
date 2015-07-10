<?php

namespace Guia\Http\Controllers;


use Guia\DataFile;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;
use Guia\Models\Archivos\Archivo;

use Illuminate\Http\Request;

class ArchivosController extends Controller {

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $doc_data['documento_id'] = $request->input('documento_id');
        $doc_data['documento_type'] = $request->input('documento_type');

        $files = $request->file('archivos');

        $archivador = new \Guia\Classes\Archivador($doc_data);
        $destinationPath = storage_path(env('ARCHIVO_GENERAL', 'archivo').'/'.$archivador->carpeta_id);//Cambiar / @linux

        foreach($files as $file){

            //Leer Información
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $file_data['filename'] = $filename;
            $file_data['mime'] = $file->getMimeType();
            $file_data['size'] = $file->getClientSize();
            //$file_data['created_original'] = ;
            $file_data['extension'] = $extension;

            $archivador->archivar($file_data);

            $file->move($destinationPath, $filename);
        }

        return redirect()->back();

        /*
         * @todo Implementar Dropzone
         */
//        $filename = \Request::file('file')->getClientOriginalName();
//        \Request::file('file')->move($destinationPath, $filename);
//
//        $link_data['presupuesto'] = \Requests::input('presupuesto');
//        $link_data['id_linkable'] = \Requests::input('id_linkable');
//        $link_data['linkable_type'] = \Requests::input('linkable_type');
//
//        $files = Storage::files();
//        foreach($files as $file) {
//
//        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function descargar($id)
    {
        $archivo = Archivo::find($id);
        $ruta_descarga = env('ARCHIVO_GENERAL', 'archivo').'/'.$archivo->carpeta_id.'/'.$archivo->name;

        if (\Storage::exists($archivo->carpeta_id.'/'.$archivo->name)) {
            $headers = ['Content-Type' => $archivo->mime];
            return response()->download($ruta_descarga, $archivo->name, $headers);
        } else {
            return redirect()->back()->with(['message' => 'No se puede descargar el archivo. Favor de comunicarse con el administrador del sisetma.', 'alert-class' => 'alert-danger']);
        }
    }

}
