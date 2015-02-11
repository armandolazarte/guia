@extends('layouts.base')

@section('contenido')
    @if(isset($modulo))
        {!! Form::model($modulo, array('action' => array('ModuloController@update', $modulo->id))) !!}
    @else
        {!! Form::open(array('action' => 'ModuloController@store')) !!}
    @endif

    {!! Form::label('ruta', 'Ruta:') !!}
    {!! Form::text('ruta') !!}

    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre') !!}

    {!! Form::label('icnono', 'Icono:') !!}
    {!! Form::text('icono') !!}

    {!! Form::label('orden', 'Orden:') !!}
    {!! Form::text('orden') !!}

    {!! Form::label('activo', 'Activo:') !!}
    {!! Form::checkbox('activo') !!}

    @foreach($roles as $role)
        {!! Form::label('modulo_role[]', $role->role_name) !!}
        @if(isset($modulo))
            {!! Form::checkbox('modulo_role[]', $role->id, $modulo->roles->contains($role->id)) !!}
        @else
            {!! Form::checkbox('modulo_role[]', $role->id, false) !!}
        @endif
    @endforeach

    {!! Form::submit('Aceptar') !!}

    {!! Form::close() !!}
@stop