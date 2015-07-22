@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if(isset($user))
                @if($role_admin)
                    @include('admin.usuarios.formCargos')
                    @include('admin.usuarios.formAcceso')
                    @include('admin.usuarios.asignaUsuario.formAsignar')
                @endif

                {!! Form::model($user, array('route' => array('admin.usuario.update', $user->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'UsuarioController@store'), array('class' => 'form-horizontal')) !!}
            @endif

                <div class="form-group">
                {!! Form::label('username', 'Código', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('nombre', 'Nombre', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('nombre', $user->nombre, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('email', 'Correo Electrónico', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'Contraseña', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('password_confirmation', 'Confirmar Contraseña', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('cargo', 'Cargo Actual', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('cargo', $user->cargo, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('prefijo', 'Prefijo', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('prefijo', $user->prefijo, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('iniciales', 'Iniciales', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('iniciales', $user->iniciales, ['class' => 'form-control']) !!}
                    </div>
                </div>

                @if($role_admin)
                    <div class="form-group">
                        <div class="col-sm-2 control-label">Roles</div>
                        <div class="col-sm-10">
                            @foreach($roles as $role)

                                @if(isset($user))
                                    {!! Form::checkbox('role_user[]', $role->id, $user->roles->contains($role->id)) !!}
                                @else
                                    {!! Form::checkbox('role_user[]', $role->id, false) !!}
                                @endif
                                    {!! Form::label('role_user[]', $role->role_name) !!}
                                ::
                            @endforeach
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formCargosModal">Registrar Cargo - URG</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAccesoModal">Crear Acceso Presupuestal</button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formAsignarUsuarioModal">Asignar Usaurio</button>
                @endif

            {!! Form::submit('Aceptar', ['class' => 'col-sm-offset-2 btn btn-success']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop