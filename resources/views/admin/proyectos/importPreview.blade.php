@extends('layouts.theme')

@section('contenido')
    <h3>Verificar Proyecto a Importar</h3>
    <table>
        <tr>
            <td>Proyecto</td><td>{{ $proyecto }} {{ $d_proyecto }}</td>
        </tr>
        <tr>
            <td>URG</td><td>{{ $urg }} {{ $d_urg }}</td>
        </tr>
        <tr>
            <td>Fondo</td><td>{{ $fondo }} {{ $d_fondo }}</td>
        </tr>
        <tr>
            <td>Monto</td><td>{{ $monto }}</td>
        </tr>
        <tr>
            <td>Año</td><td>{{ $aaaa }}</td>
        </tr>
        <tr>
            <td>Inicio</td><td>{{ $inicio }}</td>
        </tr>
        <tr>
            <td>Fin</td><td>{{ $fin }}</td>
        </tr>
    </table>

    <table border="1">
        <thead><tr>
            <th>Objetivo</th> <th>Desc. Objetivo</th> <th>RM</th> <th>COG</th> <th>Monto</th>
        </tr></thead>
        @foreach($partidas as $partida => $val)
            <tr>
                <td>{{ $val['objetivo'] }}</td>
                <td>{{ $val['d_objetivo'] }}</td>
                <td>{{ $partida }}</td>
                <td>{{ $val['cog'] }}</td>
                <td>{{ $val['monto'] }}</td>
            </tr>
        @endforeach
    </table>
@if(!empty($fondo) && count($verifica_proy) == 0)
    {!! Form::open(array('action' => 'ImportarProyectoController@store')) !!}
    {!! Form::submit('Importar Información') !!}
    {!! Form::close() !!}
@else
    @if(empty($fondo))
        <h3>El fondo no se ha dado de alta</h3>
    @endif

    @if(count($verifica_proy) > 0)
        <h3>El proyecto {{ $verifica_proy[0]->proyecto }} ya esta dado de alta</h3>
    @endif
@endif

@stop