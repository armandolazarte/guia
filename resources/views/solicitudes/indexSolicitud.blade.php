@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
    @if( count($solicitudes) > 0 )
        <table class="table table-bordered table-hover table-condensed">
            <thead>
            <tr class="active">
                <th class="text-center">Solicitud</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Proyecto</th>
                <th class="text-center">Oficio</th>
                <th class="text-center">Beneficiario</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Monto</th>
                <th class="text-center">Tipo</th>
            </tr>
            </thead>
            @foreach($solicitudes as $sol)
                @if($sol->estatus == '')
                    <tr class="warning">
                @elseif($sol->estatus == 'Recibida')
                    <tr class="info">
                @elseif($sol->estatus == 'Autorizada')
                    <tr class="success">
                @else
                    <tr>
                @endif
                    <td class="text-center"><a href="{{ action('SolicitudController@show', array($sol->id)) }}">{{ $sol->id }}</a></td>
                    <td>{{ $sol->fecha }}</td>
                    <td class="text-center">{{ $sol->proyecto->proyecto }}</td>
                    <td>{{ $sol->no_documento }}</td>
                    <td>{{ $sol->benef->benef }}</td>
                    <td>{{ $sol->estatus }}</td>
                    <td class="text-right">{{ number_format($sol->monto, 2) }}</td>
                    <td>{{ $sol->tipo_solicitud }}</td>
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