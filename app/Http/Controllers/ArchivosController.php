<?php namespace Guia\Http\Controllers;

use Guia\Archivo;
use Guia\DataFile;
use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
	public function store()
	{
        $destinationPath = storage_path().'/app';

        //Funciona con formulario normal

        $link_data['presupuesto'] = \Request::input('presupuesto');
        $link_data['linkable_id'] = \Request::input('linkable_id');
        $link_data['linkable_type'] = \Request::input('linkable_type');

        $files = \Request::file('file');

        foreach($files as $file){
            $filename = $file->getClientOriginalName();

            $file_data['filename'] = $filename;
            $file_data['directory'] = $destinationPath;
            $file_data['mime'] = $file->getMimeType();
            $file_data['size'] = $file->getClientSize();
            //$file_data['created_original'] = ;
            //$file_data['extension'] = ;

            $file->move($destinationPath, $filename);

            $archivador = new \Guia\Classes\Archivador();
            $archivador->archivar($file_data, $link_data);

            Storage::delete($filename);
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

    public function descargar($presupuesto, $id)
    {
        $archivo = Archivo::on('archivo_'.$presupuesto)->find($id);
        $data_file = DataFile::on('archivo_'.$presupuesto)->whereArchivoId($id)->get();
        return response($data_file[0]->data)->header('Content-Type', $archivo->mime);
    }

}
