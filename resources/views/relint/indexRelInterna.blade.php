@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('relint.modalFormRelInt')

            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#formRelIntModal">Crear Nueva Relación</button>

            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Fecha Envío</th>
                    <th>Estatus</th>
                    <th>Tipo de Documentos</th>
                    <th>Acción</th>
                </tr>
            @foreach($rel_internas as $rel)
                <tr>
                    <td>{{ $rel->id }}</td>
                    <td>{{ $rel->fecha_envio }}</td>
                    <td>{{ $rel->estatus }}</td>
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
