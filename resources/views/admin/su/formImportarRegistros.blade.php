@extends('layouts.theme')

@section('content')
    {!! Form::open(array('action' => 'ImportarRegistrosController@importar')) !!}
    {!! Form::label('db_origen', 'Base de Datos Origen:') !!}
    {!! Form::text('db_origen') !!}

    {!! Form::label('col_rango', 'Aplicar rango a columna:') !!}
    {!! Form::text('col_rango') !!}

    {!! Form::label('inicio', 'Inicio:') !!}
    {!! Form::text('inicio') !!}

    {!! Form::label('fin', 'Fin:') !!}
    {!! Form::text('fin') !!}

    {!! Form::select('registro', array(
        'Solicitudes' => 'Solicitudes',
        'Requisiciones' => 'Requisiciones',
        'OCs' => 'Ordenes de Compra',
        'Condiciones' => 'Actualizar Condiciones',
        'Articulos' => 'Articulos',
        'Invitaciones' => 'Invitaciones/Cuadros'
        )
    ) !!}

    {!! Form::submit('Importar') !!}
    {!! Form::close() !!}
@stop