{{--{!! Form::open(array('action' => 'ArchivosController@store', 'class'=>'dropzone', 'id'=>'guia-dropzone', 'files' => 'true')) !!}--}}
{!! Form::open(array('action' => 'ArchivosController@store', 'files' => 'true')) !!}
<div class="fallback">
    <input name="archivos[]" type="file" multiple>
    <br>
    <button type="submit" class="btn btn-success">Cargar Archivos</button>
</div>

{{-- ID --}}
{!! Form::hidden('documento_id', $documento_id) !!}

{{-- Clase (Solicitud, Requisición, Orden de Compra, Egreso) --}}
{!! Form::hidden('documento_type', $documento_type) !!}

{!! Form::close() !!}
