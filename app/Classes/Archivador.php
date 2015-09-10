<?php

namespace Guia\Classes;


use Guia\Models\Archivos\Archivo;
use Guia\Models\Archivos\Carpeta;
use Guia\Models\Archivos\CarpetaDocumento;

class Archivador
{
    public $documento_id;
    public $documento_type;
    public $carpeta_id;

    public function __construct($doc_data = array())
    {
        $this->documento_id = $doc_data['documento_id'];
        $this->documento_type = $doc_data['documento_type'];

        $this->carpetainador();
    }

    private function carpetainador()
    {
        //Busca si existe registro en carpeta_doc
        $carpeta_documento = CarpetaDocumento::whereDocumentoType($this->documento_type)
            ->whereDocumentoId($this->documento_id)
            ->first();
        if(!empty($carpeta_documento->carpeta_id)) {
            $this->carpeta_id = $carpeta_documento->carpeta_id;
        } else {
            $this->carpeta_id = $this->crearCarpeta();
        }
    }

    private function crearCarpeta() {
        //Si no existe: genera carpeta y obtiene carpeta_id
        $carpeta = new Carpeta();
        $carpeta->save();
        \Storage::makeDirectory($carpeta->id);

        //Relacionar Carpeta-Dcoumento
        $carpeta_documento = new CarpetaDocumento([
            'carpeta_id' => $carpeta->id,
            'documento_id' => $this->documento_id,
            'documento_type' => $this->documento_type
        ]);
        $carpeta->documentos()->save($carpeta_documento);

        return $carpeta->id;
    }

    public function archivar($file_data = array())
    {
        $archivo = new Archivo();
        $archivo->carpeta_id = $this->carpeta_id;
        $archivo->documento_id = $this->documento_id;
        $archivo->documento_type = $this->documento_type;
        $archivo->name = $file_data['filename'];
        $archivo->mime = $file_data['mime'];
        $archivo->size = $file_data['size'];
        $archivo->extension = $file_data['extension'];
        $archivo->save();
    }

}
