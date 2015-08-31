@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if($acciones_suministros)
                @include('oc.modalCancelarOc')
                <a href="{{ action('RequisicionController@show', $oc->req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>
                <a href="{{ action('OcsController@index', $oc->req_id) }}" class="btn btn-primary btn-sm">Regresar a Ordenes de Compra</a>
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalCancelarOc">Cancelar Orden de Compra</button>
            @endif

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Orden de Compra</th>
                    <th>Fecha OC</th>
                    <th>Proveedor</th>
                </tr>
                </thead>
                <tr>
                    <td class="text-center">{{ $oc->oc }}</td>
                    <td>{{ $oc->fecha_oc }}</td>
                    <td>{{ $oc->benef->benef }}</td>
                    <td>{{ $oc->estatus }}</td>
                </tr>
            </table>

            <div class="panel panel-info">
                <div class="panel-heading">Archivos</div>
                <div class="panel-body">
                    <div class="col-sm-4">
                        @include('partials.archivos.showFiles', array('documento_id' => $oc->id, 'documento_type' => 'Guia\Models\Oc'))
                    </div>
                    <div class="col-sm-8">
                        @include('partials.archivos.formUpload', array('documento_id' => $oc->id, 'documento_type' => 'Guia\Models\Oc'))
                    </div>

                </div>
            </div>

        </div>
    </div>
@stop
