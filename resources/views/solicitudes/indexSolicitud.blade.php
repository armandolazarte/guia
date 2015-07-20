@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
    @if( count($solicitudes) > 0 )
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Solicitud</th>
                <th>Fecha</th>
                <th>Proyecto</th>
                <th>Oficio</th>
                <th>Beneficiario</th>
                <th>Estatus</th>
                <th>Monto</th>
            </tr>
            </thead>
            @foreach($solicitudes as $sol)
                <tr>
                    <td class="text-center"><a href="{{ action('SolicitudController@show', array($sol->id)) }}">{{ $sol->id }}</a></td>
                    <td>{{ $sol->fecha }}</td>
                    <td class="text-center">{{ $sol->proyecto->proyecto }}</td>
                    <td>{{ $sol->no_documento }}</td>
                    <td>{{ $sol->benef->benef }}</td>
                    <td>{{ $sol->estatus }}</td>
                    <td class="text-right">{{ number_format($sol->monto, 2) }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="alert alert-info">
            No hay solicitudes capturadas
        </div>
    @endif
    </div>
</div>
@stop