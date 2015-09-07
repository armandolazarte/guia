@extends('layouts.theme')

@section('content')
    {!! Form::open(array('action' => 'ImportarEjercicioController@importar')) !!}

    {!! Form::select('cuenta_bancaria_id', $cuentas_bancarias) !!}

    {!! Form::label('db_origen', 'Base de Datos Origen:') !!}
    {!! Form::text('db_origen') !!}

    {!! Form::label('col_rango', 'Aplicar rango a columna:') !!}
    {!! Form::text('col_rango') !!}

    {!! Form::label('inicio', 'Inicio:') !!}
    {!! Form::text('inicio') !!}

    {!! Form::label('fin', 'Fin:') !!}
    {!! Form::text('fin') !!}

    {!! Form::select('registro', array(
        'Egresos' => 'Egresos',
        'Ingresos' => 'Ingresos',
        'Cheques' => 'Cheques',
        'RelacionPagos' => 'Relación Pagos (Sol/Oc -> Cheque/Egreso)'
        )
    ) !!}

    {!! Form::submit('Importar') !!}
    {!! Form::close() !!}
@stop