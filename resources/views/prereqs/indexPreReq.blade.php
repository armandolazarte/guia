@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if( count($prereqs) > 0 )
            <table class="table-hover">
                <thead>
                <tr>
                    <th>Requisición</th>
                    <th>Fecha</th>
                    <th>Unidad Responsable</th>
                    <th>Etiqueta</th>
                    <th>Estatus</th>
                </tr>
                </thead>
                @foreach($prereqs as $prereq)
                    <tr>
                        <td><a href="{{ action('PreReqController@show', array($prereq->id)) }}">{{ $prereq->sol }}</a></td>
                        <td>{{ $prereq->fecha }}</td>
                        <td>{{ $prereq->urg->d_urg }}</td>
                        <td>{{ $prereq->etiqueta }}</td>
                        <td>{{ $prereq->estatus }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="alert alert-info">
                No hay solicitudes por listar
            </div>
        @endif
    </div>
</div>
@stop