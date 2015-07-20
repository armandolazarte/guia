@extends('layouts.theme')

@section('content')

    @include('solicitudes.partialInfoSol', array('solicitud' => $solicitud))

    {{--@include('solicitudes.partialInfoSolRecursos', array('solicitud' => $solicitud))--}}

    @if(isset($solicitud) && isset($recurso_id))
        {!! Form::open(array('action' => array('SolicitudRecursosController@update', $solicitud->id, $recurso_id), 'class' => 'form-inline', 'method' => 'patch')) !!}
    @else
        {!! Form::open(array('action' => 'SolicitudRecursosController@store', 'class' => 'form-inline')) !!}
    @endif

    @include('partials.formErrors')

    @if(count($objetivos) > 0)
        <div class="form-group">
            <label for="objetivo_id">Objetivo</label>
            <div class="input-group">
                <select class="form-control" name="objetivo_id">
                    @foreach($objetivos as $obj)
                        <option value="{{ $obj->id }}">{{ $obj->objetivo }} {{ $obj->d_objetivo }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @else
        <div class="form-group">
            <label for="rm_id">Recurso Material</label>
            <div class="input-group">
                <select class="form-control" name="rm_id">
                    @foreach($rms as $rm)
                        <option value="{{ $rm->id }}">{{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} ({{ $rm->cog->d_cog }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="form-group">
        <label class="sr-only" for="monto">Monto</label>
        <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto" value="{{ $monto or '' }}">
        </div>
    </div>

    {!! Form::hidden('solicitud_id', $solicitud->id) !!}
    {!! Form::hidden('tipo_solicitud', $solicitud->tipo_solicitud) !!}
    {{--Impide editar el monto si es un vale y está desglosado por objetivo--}}
    @if(count($objetivos) == 0)
        {!! Form::submit('Aceptar', array('class' => 'btn btn-primary')) !!}
    @else
        <div class="alert-info">
            Debido a disposiciones recientes el monto por objetivo solo puede ser borrado, por lo que el desglose deberá realizarse por Recurso Material
        </div>
    @endif
    {!! Form::close() !!}

    @if(isset($solicitud) && isset($recurso_id))
        {!! Form::open(array('action' => array('SolicitudRecursosController@destroy', $solicitud->id, $recurso_id), 'method' => 'delete')) !!}
        {!! Form::submit('Borrar Recurso', array('class' => 'btn btn-danger')) !!}
        {!! Form::close() !!}
    @endif

@stop