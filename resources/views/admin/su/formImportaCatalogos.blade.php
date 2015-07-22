@extends('layouts.theme')

@section('content')
    {!! Form::open(array('action' => 'ImportaCatalogosController@importar')) !!}
    {!! Form::label('db_origen', 'Base de Datos Origen:') !!}
    {!! Form::text('db_origen') !!}
    {!! Form::select('catalogo',
        array(
            'P3E-LGCG' => array(
                        'URG' => 'URG',
                        'Fondos' => 'Fondos',
                        'Proyectos' => 'Proyectos',
                        'Cuentas' => 'Cuentas',
                        'Beneficiarios' => 'Beneficiarios',
                        'COG' => 'COG',
                        'Usuarios' => 'Usuarios',
                        'ActualizarDerechosUsuario' => 'Actualizar Derechos de Usuarios',
                        'Rms' => 'Rms',
                        'UrgExternas' => 'URG Externas'
            ),
            'Fondos Externos' => array(
                        'ProyectosFext' => 'Proyectos FEXT'
            )
        )
    ) !!}
    {!! Form::submit('Importar') !!}
    {!! Form::close() !!}
@stop