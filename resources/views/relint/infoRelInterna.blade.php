@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {{-- @todo Solo Mostrar si no ha sido enviada y uno la creó --}}
            {!! Form::open(['action' => ['RelacionInternaController@update', $rel_interna->id], 'method' => 'patch']) !!}
            {!! Form::label('recibe', 'Enviar a:') !!}
            {!! Form::select('grupo_destino', ['' => 'Enviar a Área'] + $arr_grupos) !!}
            {!! Form::select('usuario_destino', ['' => 'Enviar a Usuario'] + $arr_usuarios) !!}
            {!! Form::hidden('accion', 'Enviar') !!}
            {!! Form::submit('Enviar', ['class' => 'btn btn-sm btn-success']) !!}
            {!! Form::close() !!}

        </div>
    </div>
@stop
