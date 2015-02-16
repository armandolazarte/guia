@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('solicitudes.partialInfoSol', array('sol' => $solicitud))

            @include('solicitudes.partialInfoSolRecursos', array('sol' => $solicitud))

            @if($solicitud->estatus == "")
                <a href="{{ action('SolicitudRecursosController@create', array($solicitud->id)) }}" class="btn btn-primary">Agregar Recursos</a>
            @endif
        </div>
    </div>
@stop
