@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Conciliación Bancaria</h2>

            @include('partials.selCuentaBancaria')
            @include('conciliacion.partialEnlacesConciliacion')

        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('js/sel-cuenta-bancaria.js') }}"></script>
@stop