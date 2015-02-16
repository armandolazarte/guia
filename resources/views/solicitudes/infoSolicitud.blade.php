@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if(Session::has('message'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif

            @include('solicitudes.partialInfoSol', array('sol' => $solicitud))

            @include('solicitudes.partialInfoSolRecursos', array('sol' => $solicitud))

            @if($solicitud->estatus == "")
                <a href="{{ action('SolicitudRecursosController@create', array($solicitud->id)) }}" class="btn btn-primary">Agregar Recursos</a>
            @endif
        </div>
    </div>
@stop
