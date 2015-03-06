@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table-hover">
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Correo</th>
                    <th>Activo</th>
                </tr>
                </thead>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ action('UsuarioController@show', $user->id) }}">{{ $user->username }}</a></td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->cargo }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->active }}</td>
                </tr>
            @endforeach
            </table>
        </div>
    </div>
@stop