@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if($accion == 'agregar-docs')
                @include('partials.json-message')
                <a href="{{ action('RelacionInternaController@show', $rel_interna->id) }}" class="btn btn-sm btn-primary">Terminar y ver Relación</a>
            @elseif($accion == 'recibir-docs')
                {!! Form::open(['action' => ['RelacionInternaDocController@update', $rel_interna->id], 'method' => 'patch']) !!}
                {!! Form::submit('Recibir', ['class' => 'btn btn-sm btn-success']) !!}
            @endif

            @if($rel_interna->tipo_documentos == 'Egresos')
                @include('relint.partialFormEgresos')
            @endif

            @if($accion == 'recibir-docs')
                {!! Form::close() !!}
            @endif

        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('js/ajax-helpers.js') }}"></script>
@stop