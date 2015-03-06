@extends('layouts.theme')

@section('css')
    @parent
    <link href="{{ asset('assets/css/dropzone.css') }}" rel="stylesheet" type="text/css" media="screen">
@stop

@section('contenido')

    <!--<form action="{{ action('ImportarProyectoController@postUpload') }}" class="dropzone" id="gia-dropzone">-->
    {!! Form::open(array('action' => 'ImportarProyectoController@postUpload', 'class'=>'dropzone', 'id'=>'guia-dropzone', 'files' => 'true')) !!}
        <div class="fallback">
            <input name="file" type="file" multiple>
            <button type="submit">Cargar</button>
        </div>
    {!! Form::close() !!}

    <table border="1">
    @foreach($files as $file)
        <tr>
            <td>{!! $file !!}</td>
            <td>
                {!! Form::open(array('action'=>'ImportarProyectoController@convertir')) !!}
                    <input type="hidden" name="fileName" value="{!! $file !!}">
                    <button type="submit">Importar</button>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </table>
@stop

@section('js')
    @parent
    <script src="{{ asset('assets/js/plugins/dropzone/dropzone.js') }}"></script>
@stop