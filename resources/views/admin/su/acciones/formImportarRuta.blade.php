@extends('layouts.theme')

@section('content')
    <h3>Importar Ruta</h3>

    {!! Form::open(array('action' => 'AccionesController@store', 'class' => 'form')) !!}

    @foreach($routeCollection as $route)
        <div class="checkbox">
            <label>
                {!! Form::checkbox('arr_rutas[]', $route->getPath(), false) !!}
                {{ $route->getPath() }}
            </label>
        </div>
    @endforeach

    {!! Form::submit('Importar Rutas') !!}
    {!! Form::close() !!}
@stop
