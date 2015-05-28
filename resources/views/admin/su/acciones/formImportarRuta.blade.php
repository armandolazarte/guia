@extends('layouts.theme')

@section('content')
    <h3>Importar Ruta</h3>

    {!! Form::open(array('action' => 'AccionesController@store', 'class' => 'form')) !!}
        <table class="table table-bordered table-condensed">
            <tr>
                <th>Action</th>
                <th>Route</th>
                <th>HTTP Method</th>
            </tr>
            @foreach($routeCollection as $route)
                <tr>
                    <td>
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox('arr_rutas[]', str_replace('Guia\Http\Controllers\\', '', $route->getActionName()), false) !!}
                                {{ str_replace('Guia\Http\Controllers\\', '', $route->getActionName()) }}
                            </label>
                        </div>
                    </td>
                    <td>{{ $route->getPath() }}</td>
                    <td>{{$route->getMethods()[0] }}</td>
                </tr>
            @endforeach
            <tr></tr>
        </table>
    {!! Form::submit('Importar Rutas') !!}
    {!! Form::close() !!}
@stop
