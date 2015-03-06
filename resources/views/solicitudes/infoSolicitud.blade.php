@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('solicitudes.partialInfoSol', array('sol' => $solicitud))

            @include('solicitudes.partialInfoSolRecursos', array('sol' => $solicitud))

            @if($solicitud->estatus == "")
                <a href="{{ action('SolicitudRecursosController@create', array($solicitud->id)) }}" class="btn btn-primary">Agregar Recursos</a>
            @endif

            @if($solicitud->estatus == '')
                {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Enviar">
                    <button type="submit" class="btn btn-success">Enviar a Finanzas</button>
                {!! Form::close() !!}
            @endif

            @if($solicitud->estatus == 'Enviada')
                    {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Recuperar">
                    <button type="submit" class="btn btn-warning">Recuperar</button>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
@stop
