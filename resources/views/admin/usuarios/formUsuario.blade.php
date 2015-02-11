@extends('layouts.base')

@section('contenido')

    @if(isset($user))
        {!! Form::model($user, array('route' => array('admin.usuario.update', $user->id), 'method' => 'patch')) !!}
    @else
        {!! Form::open(array('action' => 'UsuarioController@store')) !!}
    @endif

{{-- @foreach($errors->get('username', '<span>:message</span>') as $message) --}}
    @foreach($errors->get('username') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('username', 'Código') !!}
    {!! Form::text('username') !!}

    @foreach($errors->get('nombre') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre') !!}

    @foreach($errors->get('email') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('email', 'Correo Electrónico') !!}
    {!! Form::text('email') !!}

    @foreach($errors->get('password') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('password', 'Contraseña') !!}
    {!! Form::password('password') !!}

    @foreach($errors->get('password_confirmation') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('password_confirmation', 'Confirmar Contraseña') !!}
    {!! Form::password('password_confirmation') !!}

    @foreach($errors->get('cargo') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('cargo', 'Cargo') !!}
    {!! Form::text('cargo') !!}

    @foreach($errors->get('prefijo') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('prefijo', '') !!}
    {!! Form::text('prefijo') !!}

    @foreach($errors->get('iniciales') as $message)
        {!! $message !!}
    @endforeach
    {!! Form::label('iniciales', 'Iniciales') !!}
    {!! Form::text('iniciales') !!}

    @foreach($roles as $role)
        {!! Form::label('role_user[]', $role->role_name) !!}
        @if(isset($user))
            {!! Form::checkbox('role_user[]', $role->id, $user->roles->contains($role->id)) !!}
        @else
            {!! Form::checkbox('role_user[]', $role->id, false) !!}
        @endif
    @endforeach

    {!! Form::submit('Aceptar') !!}

    {!! Form::close() !!}
@stop