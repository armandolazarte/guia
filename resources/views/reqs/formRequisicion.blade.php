@extends('layouts.base')

@section('contenido')

    @if(isset($req))
        {!! Form::model($req, array('action' => array('RequisicionController@update', $req->id))) !!}
    @else
        {!! Form::open(array('action' => 'RequisicionController@store')) !!}
    @endif

    @foreach($errors->get('proyecto_id') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('proyecto_id', 'Proyecto') !!}
    {!! Form::select('proyecto_id', $proyectos) !!}

    @foreach($errors->get('urg_id') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('urg_id', 'Unidad Responsable de Aplicación') !!}
    <select name="urg_id">
        @foreach($urgs as $urg)
            <option value="{!! $urg->id !!}">{!! $urg->urg !!} - {!! $urg->d_urg !!}</option>
        @endforeach
    </select>

    @foreach($errors->get('etiqueta') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('etiqueta', 'Etiqueta') !!}
    {!! Form::text('etiqueta') !!}

    @foreach($errors->get('lugar_entrega') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('lugar_entrega', 'Lugar de Entrega') !!}
    {!! Form::text('lugar_entrega') !!}

    {!! Form::label('obs', 'Observaciones') !!}
    {!! Form::text('obs') !!}

    {!! Form::submit('Aceptar') !!}

    {!! Form::close() !!}

@stop