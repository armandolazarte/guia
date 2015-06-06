<?php

namespace Guia\Classes;

use Guia\Archivo;
use Guia\DataFile;
use Illuminate\Support\Facades\Storage;

class Archivador {

    public function archivar($file_data = array(), $link_data = array())
    {
        if(!empty($link_data['presupuesto']))
        {
            $archivo = new Archivo();
            $archivo->setConnection('archivo_'.$link_data['presupuesto']);
            $archivo->linkable_id = $link_data['linkable_id'];
            $archivo->linkable_type = $link_data['linkable_type'];

            $archivo->name = $file_data['filename'];
            $archivo->mime = $file_data['mime'];
            $archivo->size = $file_data['size'];
            //$archivo->extension = $file_data['extension'];
            $archivo->save();

            $data_file = new DataFile();
            $data_file->setConnection('archivo_2015');
            $data_file->data = Storage::get($file_data['filename']);
            $data_file->archivo()->associate($archivo);
            $data_file->save();
        }

    }

    public function mostrar()
    {

    }

}