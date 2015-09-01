@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {{-- Solo se muestra si no ha sido recibida y el usuario registrado la creó --}}
            @if($rel_interna->envia == \Auth::user()->id && ($rel_interna->estatus == '' || $rel_interna->estatus == 'Enviada'))
            {!! Form::open(['action' => ['RelacionInternaController@update', $rel_interna->id], 'method' => 'patch']) !!}
            {!! Form::label('recibe', 'Enviar a:') !!}
            {!! Form::select('grupo_destino', ['' => 'Enviar a Área'] + $arr_grupos) !!}
            {!! Form::select('usuario_destino', ['' => 'Enviar a Usuario'] + $arr_usuarios) !!}
            {!! Form::hidden('accion', 'Enviar') !!}
            {!! Form::submit('Enviar', ['class' => 'btn btn-sm btn-success']) !!}
            {!! Form::close() !!}
            @endif

            @if(count($documentos) > 0)
                @if($rel_interna->tipo_documentos == 'Egresos')
                    @include('relint.partialFormEgresos')
                @endif

                @if($rel_interna->tipo_documentos == 'Solicitudes')
                    @include('relint.partialFormSolicitudes')
                @endif
            @else
                <div class="alert alert-warning" role="alert">No hay documentos relacionados</div>
            @endif

        </div>
    </div>
@stop
