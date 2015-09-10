@extends('layouts.theme')

@section('content')

    {{-- Acciones Unidad de Presupuesto --}}
    @if($acciones_presu)
        @include('solicitudes.accionesPresuSol', array('solicitud' => $solicitud))
    @endif

    <div class="row">
        <div class="col-md-12">

            @include('solicitudes.partialInfoSol', array('sol' => $solicitud))

            @include('solicitudes.partialInfoSolRecursos', array('sol' => $solicitud, 'arr_roles' => $arr_roles))

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="btn-group btn-group-sm" role="group">
                @if($solicitud->estatus == "")
                    <a class="btn btn-primary" href="{{ action('SolicitudRecursosController@create', array($solicitud->id)) }}">Agregar Recursos</a>
                    <a class="btn btn-primary" href="{{ action('SolicitudController@edit', array($solicitud->id)) }}">Editar Información</a>
                @endif
                <a class="btn btn-primary" href="{{ action('SolicitudController@formatoPdf', array($solicitud->id)) }}" target="_blank">Formato (PDF)</a>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="row">
                @if($solicitud->estatus == '' && $solicitud->monto > 0)
                    <div class="col-md-4">
                        {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                        <input type="hidden" name="accion" value="Enviar">
                        <button type="submit" class="btn btn-success">Enviar a Finanzas</button>
                        {!! Form::close() !!}
                    </div>
                @endif

                @if($solicitud->estatus == 'Enviada')
                    <div class="col-md-4">
                        {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                        <input type="hidden" name="accion" value="Recuperar">
                        <button type="submit" class="btn btn-warning">Recuperar</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <br>
    @include('partials.archivos.modalBorrarArchivo')
    <div class="panel panel-info">
        <div class="panel-heading">Archivos</div>
        <div class="panel-body">
            <div class="col-sm-8">
                @include('partials.archivos.showFiles', array('documento_id' => $solicitud->id, 'documento_type' => 'Guia\Models\Solicitud'))
            </div>
            <div class="col-sm-4">
                @include('partials.archivos.formUpload', array('documento_id' => $solicitud->id, 'documento_type' => 'Guia\Models\Solicitud'))
                <br><div class="alert-warning">La opción para eliminar archivos solo está habilitada si la solicitud no ha sido enviada</div>
            </div>
        </div>
    </div>
@stop
@section('js')
    @parent
    <script src="{{ asset('js/borrar-archivo-helper.js') }}"></script>
@stop
