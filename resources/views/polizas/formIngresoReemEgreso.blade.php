@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {{-- Mostrar información general del egreso --}}
            <table class="table table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Cuenta Bancaria</th>
                    <th>Poliza/Cheque</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-info">
                    <td>{{ $egreso->cuentaBancaria->cuenta_bancaria }}</td>
                    @if(!empty($egreso->cheque))
                        <td>Ch. {{ $egreso->cheque }}</td>
                    @else
                        <td>Pol. {{ $egreso->poliza }}</td>
                    @endif
                    <td>{{ $egreso->fecha }}</td>
                    <td>{{ $egreso->benef->benef }}</td>
                    <td class="text-right">{{ number_format($egreso->monto, 2) }}</td>
                </tr>
                <tr class="bg-info">
                    <td colspan="5"><b>Concepto: </b>{{ $egreso->concepto }}</td>
                </tr>
                </tbody>
            </table>

            {!! Form::open(array('action' => 'PolizaController@store', 'role' => 'form', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                {!! Form::label('no_identificado_id', 'Depósito No Identificado', ['class' => 'col-sm-3']) !!}
                <div class="col-sm-4">
                    {!! Form::select('no_identificado_id', $no_identificados) !!}
                </div>
            </div>

            @foreach($arr_rms as $rm_id => $rm)
                <div class="form-group">
                    {!! Form::label('monto_rm_id_'.$rm_id, 'RM: '.$rm['rm'].' / '.$rm['cog'], ['class' => 'col-sm-3']) !!}
                    <div class="col-sm-4">
                    {{-- Agregar "columnas" ejercido, comprobado, reembolsado --}}
                        {!! Form::text('monto_rm_id_'.$rm_id, null, ['class' => 'form-control', 'placeholder' => 'Monto a reembolsar']) !!}
                    </div>
                </div>
            @endforeach

            {!! Form::hidden('egreso_id', $egreso->id) !!}
            {!! Form::hidden('tipo', 'Ingreso') !!}
            <div class="col-sm-offset-3 col-sm-4">
                {!! Form::submit('Aceptar', ['class' => 'btn btn-success col-sm-4']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
