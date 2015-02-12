@extends('layouts.base')

@section('contenido')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(isset($articulo))
        {!! Form::model($articulo, array('action' => array('ArticulosController@update', $articulo->id), 'method' => 'patch')) !!}
    @else
        {!! Form::open(array('action' => 'ArticulosController@store')) !!}
    @endif

    @foreach($errors->get('req_id') as $message)
        {!! $message !!}
    @endforeach

    <table border="1">
        <thead>
        <tr>
            <th>Descripción del artículo</th>
            <th>Cantidad</th>
            <th>Unidad</th>
        </tr>
        </thead>
        <tr>
            <td>
                @foreach($errors->get('articulo') as $message)
                    {!! $message !!}
                @endforeach
                {!! Form::textarea('articulo') !!}
            </td>
            <td>
                @foreach($errors->get('cantidad') as $message)
                    {!! $message !!}
                @endforeach
                {!! Form::text('cantidad', isset($articulo->cantidad) ? $articulo->cantidad : '', array('size' => '10')) !!}
            </td>
            <td>
                @foreach($errors->get('unidad') as $message)
                    {!! $message !!}
                @endforeach
                {!! Form::select('unidad', $unidades) !!}
            </td>
        </tr>
    </table>

    {!! Form::hidden('req_id', $req->id) !!}
    {!! Form::submit('Aceptar') !!}
    {!! Form::close() !!}

@if(isset($articulo))
    {!! Form::open(array('action' => array('ArticulosController@destroy', $articulo->id), 'method' => 'delete')) !!}
    {!! Form::submit('Borrar Artículo') !!}
    {!! Form::close() !!}
@endif

@stop