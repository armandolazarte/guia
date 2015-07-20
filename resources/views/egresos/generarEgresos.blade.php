@extends('layouts.theme')

@section('content')

    <div class="row">
        <div class="col-md-12">

            {{--@include('partials.json-message')--}}

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
                    <th>Monto a Solicitar</th>
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
                            {!! Form::open(array('action' => 'GenerarEgresoController@store')) !!}
                            {!! Form::hidden('doc_id', $sol->id) !!}
                            {!! Form::hidden('doc_type', 'Solicitud') !!}
                            {!! Form::hidden('cuenta_bancaria_id', 1) !!}
                            {!! Form::hidden('fecha', $fecha) !!}
                            {!! Form::hidden('tipo_egreso', 'cheque') !!}
                            {!! Form::submit('Generar Cheque', array('class' => 'btn btn-sm btn-success')) !!}
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
                    <th>Monto a Solicitar</th>
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
                                {!! Form::open(array('action' => 'GenerarEgresoController@store')) !!}
                                {!! Form::hidden('doc_id', $oc->id) !!}
                                {!! Form::hidden('doc_type', 'Oc') !!}
                                {!! Form::hidden('cuenta_bancaria_id', 1) !!}
                                {!! Form::hidden('fecha', $fecha) !!}
                                {!! Form::hidden('tipo_egreso', 'cheque') !!}
                                {!! Form::submit('Generar Cheques', array('class' => 'btn btn-sm btn-success')) !!}
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
@stop
