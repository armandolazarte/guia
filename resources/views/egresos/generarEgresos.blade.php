@extends('layouts.theme')

@section('content')

    <div class="row">
        <div class="col-md-12">

            {{--@include('partials.json-message')--}}
            @include('egresos.modalGenerarEgreso')
            <table class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th>Solicitud</th>
                    <th>ID AFIN</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Proyecto</th>
                    <th>Estatus</th>
                    <th>Monto</th>
                    <th colspan="2">Acciones</th>
                </tr>
                </thead>
                @foreach($solicitudes as $sol)
                    <tr id="sol-{{ $sol->id }}">
                        <td>{{ $sol->id  }}</td>
                        <td>{{ $sol->no_afin }}</td>
                        <td>{{ $sol->fecha }}</td>
                        <td>{{ $sol->benef->benef }}</td>
                        <td>{{ $sol->proyecto->proyecto }}</td>
                        <td>{{ $sol->estatus }}</td>
                        <td>{{ number_format($sol->monto, 2) }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm generar-egreso-modal" data-toggle="modal" data-target="#modalGenerarEgreso" id="modal-Solicitud-{{ $sol->id }}">Generar Cheque</button>
                        </td>
                        <td>
                            {!! Form::open(array('action' => 'GenerarEgresoController@store')) !!}
                            {!! Form::hidden('doc_id', $sol->id) !!}
                            {!! Form::hidden('doc_type', 'Solicitud') !!}
                            {!! Form::hidden('cuenta_bancaria_id', 1) !!}
                            {!! Form::hidden('fecha', $fecha) !!}
                            {!! Form::hidden('tipo_egreso', 'cheque') !!}
                            {!! Form::submit('Pagar 100%', array('class' => 'btn btn-sm btn-success')) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach

                <thead>
                <tr>
                    <th>Orden de Compra</th>
                    <th>Requisición</th>
                    <th>Fecha OC</th>
                    <th>Proveedor</th>
                    <th>Proyecto</th>
                    <th>Estatus OC</th>
                    <th>Monto</th>
                    <th colspan="2">Acciones</th>
                </tr>
                </thead>

                @foreach($reqs as $req)
                    @foreach($req->ocs as $oc)
                        <tr id="oc-{{ $oc->id }}">
                            <td>{{ $oc->oc }}</td>
                            <td>{{ $req->req }}</td>
                            <td>{{ $req->fecha_req }}</td>
                            <td>{{ $oc->benef->benef }}</td>
                            <td>{{ $req->proyecto->proyecto }}</td>
                            <td>{{ $oc->estatus }}</td>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm generar-egreso-modal" data-toggle="modal" data-target="#modalGenerarEgreso" id="modal-Oc-{{ $oc->id }}">Generar Cheque</button>
                            </td>
                            <td>
                                {!! Form::open(array('action' => 'GenerarEgresoController@store')) !!}
                                {!! Form::hidden('doc_id', $oc->id) !!}
                                {!! Form::hidden('doc_type', 'Oc') !!}
                                {!! Form::hidden('cuenta_bancaria_id', 1) !!}
                                {!! Form::hidden('fecha', $fecha) !!}
                                {!! Form::hidden('tipo_egreso', 'cheque') !!}
                                {!! Form::submit('Pagar 100%', array('class' => 'btn btn-sm btn-success')) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endforeach

            </table>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('js/ajax-helpers.js') }}"></script>
    <script>
        $(function(){
            $('.generar-egreso-modal').on('click', function(e) {
                var id_array = $(this).attr('id').split('-');//modal-sol||oc-id
                var doc_id = id_array[2];
                var doc_type = id_array[1];

                $('.ruta-dinamica').attr('href', function (i, value) {
                    /**
                     * re-crea enlace original
                     * Se requiere para cuando se cancela la acción para seleccionar un documento diferente
                     */
                    var href_array = value.split('/');
                    var href_original = 'http:/';
                    for (i = 2; i < 8; i++) {
                        href_original += '/' + href_array[i];
                    }

                    return href_original + '/' + doc_type + '/' + doc_id;
                });
            });
        });
    </script>
@stop
