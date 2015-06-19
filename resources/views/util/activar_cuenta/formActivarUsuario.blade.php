@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('partials.formErrors')

            {!! Form::model($user, array('action' => array('Util\ActivarCuentaController@activarUsuario', $user->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                {!! Form::label('username', 'Código', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('username', $user->username, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('prefijo', 'Título', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::text('prefijo', $user->prefijo, ['class' => 'form-control']) !!}
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
                {!! Form::label('password', 'Nueva Contraseña', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-10">
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Confirmar Nueva Contraseña', ['class' => 'col-sm-2 control-label']) !!}
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


            {!! Form::hidden('active', 1) !!}
            {!! Form::submit('Aceptar', ['class' => 'col-sm-offset-2 btn btn-success']) !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop
