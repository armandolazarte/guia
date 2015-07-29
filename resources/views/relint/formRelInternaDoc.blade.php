@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('partials.json-message')

            <a href="{{ action('RelacionInternaController@show', $rel_interna->id) }}" class="btn btn-sm btn-primary">Terminar y ver Relación</a>

            @if($rel_interna->tipo_documentos == 'Egresos')
                @include('relint.partialFormEgresos')
            @endif

        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('js/ajax-helpers.js') }}"></script>
@stop
