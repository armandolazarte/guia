@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('relint.modalFormRelInt')

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formRelIntModal">Crear Nueva Relación</button>

            <table class="table table-bordered table-hover">
                <thead>
                <tr><th class="text-center" colspan="7">Relaciones destinadas a {{ \Auth::user()->nombre }}</th></tr>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Envía</th>
                    <th class="text-center">Fecha Envío</th>
                    <th class="text-center">Destinatario</th>
                    <th class="text-center">Fecha Recibe</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Tipo de Documentos</th>
                    <th class="text-center">Acción</th>
                </tr>
                </thead>
            @foreach($rel_destino_user as $rel)
                <tr>
                    <td class="text-center">{{ $rel->id }}</td>
                    <td>{{ $rel->nombre_envia }}</td>
                    <td class="text-center">{{ $rel->fecha_envio_info }}</td>
                    <td class="text-center">{{ $rel->fecha_revision_info }}</td>
                    <td class="text-center">{{ $rel->estatus }}</td>
                    <td>{{ $rel->tipo_documentos }}</td>
                    <td>
                        @if($rel->estatus != 'Recibida')
                        <a href="{{ action('RelacionInternaDocController@edit', $rel->id) }}">Recibir</a>
                        @endif
                    </td>
                </tr>
            @endforeach
                @foreach($rel_destino_grupo as $grupo)
                    <thead>
                    <tr><th class="text-center" colspan="7">Relaciones destinadas a {{ $grupo->grupo }}</th></tr>
                    </thead>
                    @foreach($grupo->relInternas as $rel)
                        <tr>
                            <td class="text-center">{{ $rel->id }}</td>
                            <td>{{ $rel->nombre_envia }}</td>
                            <td class="text-center">{{ $rel->fecha_envio_info }}</td>
                            <td class="text-center">{{ $rel->fecha_revision_info }}</td>
                            <td class="text-center">{{ $rel->estatus }}</td>
                            <td>{{ $rel->tipo_documentos }}</td>
                            <td>
                                @if($rel->estatus != 'Recibida')
                                    <a href="{{ action('RelacionInternaDocController@edit', $rel->id) }}">Recibir</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </table>

            <table class="table table-bordered table-hover">
                <thead>
                <tr><th colspan="7">Relaciones Enviadas</th></tr>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Envía</th>
                    <th class="text-center">Fecha Envío</th>
                    <th class="text-center">Fecha Recibe</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Tipo de Documentos</th>
                    <th class="text-center">Acción</th>
                </tr>
                </thead>

                @foreach($rel_enviadas as $rel)
                    <tr>
                        <td class="text-center">{{ $rel->id }}</td>
                        <td>{{ $rel->nombre_envia }}</td>
                        <td class="text-center">{{ $rel->fecha_envio_info }}</td>
                        <td class="text-center">{{ $rel->fecha_revision_info }}</td>
                        <td class="text-center">{{ $rel->estatus }}</td>
                        <td>{{ $rel->tipo_documentos }}</td>
                        <td>
                            @if($rel->estatus != 'Recibida')
                                <a href="{{ action('RelacionInternaDocController@edit', $rel->id) }}">Recibir</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
