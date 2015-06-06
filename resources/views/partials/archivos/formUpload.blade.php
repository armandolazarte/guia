{{--{!! Form::open(array('action' => 'ArchivosController@store', 'class'=>'dropzone', 'id'=>'guia-dropzone', 'files' => 'true')) !!}--}}
{!! Form::open(array('action' => 'ArchivosController@store', 'files' => 'true')) !!}
<div class="fallback">
    <input name="file[]" type="file" multiple>
    <br>
    <button type="submit" class="btn btn-success">Cargar Archivos</button>
</div>

{{-- Año presupuestal --}}
{!! Form::hidden('presupuesto', $presupuesto) !!}

{{-- ID --}}
{!! Form::hidden('linkable_id', $linkable_id) !!}

{{-- Clase (Solicitud, Requisición, Orden de Compra, Egreso) --}}
{!! Form::hidden('linkable_type', $linkable_type) !!}

{!! Form::close() !!}
