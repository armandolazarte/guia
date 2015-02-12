@extends('layouts.base')

@section('contenido')

@if(isset($reqs))
    <table border="1">
        <thead>
        <tr>
            <th>Requisición</th>
            <th>Fecha</th>
            <th>Unidad Responsable</th>
            <th>Etiqueta</th>
            <th>Estatus</th>
            <th>Monto</th>
            <th>Orden de Compra</th>
            <th>Fecha OC</th>
            <th>Estatus OC</th>
            <th>Responsable Adq.</th>
        </tr>
        </thead>
        @foreach($reqs as $req)
            <tr>
                <td><a href="{{ action('RequisicionController@show', array($req->id)) }}">{{ $req->req }}</a></td>
                <td>{{ $req->fecha_req }}</td>
                <td>{{ $req->urg->d_urg }}</td>
                <td>{{ $req->etiqueta }}</td>
                <td>{{ $req->estatus }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </table>
@else
    <h3>No hay requisiciones que mostrar</h3>
@endif


@stop