@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            Información de Usuario

            <table class="table-bordered table-condensed">
                <tr>
                    <td>Código</td>
                    <td>{{ $user->username }}</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>
                        {{ !empty($user->prefijo) ? $user->prefijo.'. ' : ''  }} {{ $user->nombre }}
                    </td>
                </tr>
                <tr>
                    <td>Correo Electronico</td>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <td>Cargo</td>
                    <td>{{ $user->cargo }}</td>
                </tr>
                <tr>
                    <td>Iniciales</td>
                    <td>{{ $user->iniciales }}</td>
                </tr>
                <tr>
                    <td>Roles</td>
                    <td>
                        @foreach($user->roles as $role)
                        {{ $role->role_name }}<br />
                        @endforeach
                    </td>
                </tr>
                <tr><td colspan="2"><a href="{{ action('UsuarioController@edit', $user->id) }}" class="btn btn-primary">Editar</a> </td></tr>
            </table>

        </div>
    </div>
@stop