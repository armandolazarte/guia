@extends('layouts.theme')

@section('contenido')

    <a href="{{ action('ModuloController@create') }}">Capturar Modulo</a>

    @if( count($modulos) > 0 )
        <table border="1">
            <thead><tr>
                <th>ID</th>
                <th>Ruta</th>
                <th>Nombre</th>
                <th>Icono</th>
                <th>Orden</th>
                <th>Activo</th>
                <th>Roles</th>
            </tr></thead>
            @foreach($modulos as $modulo)
                <tr>
                    <td><a href="{{ action('ModuloController@edit', $modulo->id) }}">{{ $modulo->id }}</a></td>
                    <td>{{ $modulo->ruta }}</td>
                    <td>{{ $modulo->nombre }}</td>
                    <td>{{ $modulo->icono }}</td>
                    <td>{{ $modulo->orden }}</td>
                    <td>{{ $modulo->activo }}</td>
                    <td>
                        @foreach($modulo->roles as $role)
                            {{ $role->role_name }}<br />
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h3>No hay modulos</h3>
    @endif

@stop