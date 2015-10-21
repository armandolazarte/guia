@extends('layouts.theme')

@section('content')
    @if($no_identificado->identificado == 0)
        @include('no_identificados.modalBorrarNoIdentificado')
    @endif
    <div class="row">
        <div class="col-md-12">
            <a href="{{ action('NoIdentificadoController@create') }}" class="btn btn-sm btn-primary">Nuevo Depósito No Identificado</a>

            <table class="table table-bordered table-condensed table-hover">
                <thead>
                <tr class="active">
                    <th class="text-center">Cuenta Bancaria</th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Monto</th>
                    <th class="text-center">No. Depósito</th>
                    <th class="text-center">Identificado</th>
                    <th class="text-center">Fecha Identificado</th>
                </tr>
                </thead>
                <tr class="{{ $no_identificado->identificado == 1 ? 'active' : 'warning' }}">
                    <td class="text-center">{{ $no_identificado->cuentaBancaria->cuenta_bancaria }}</td>
                    <td class="text-center">{{ $no_identificado->id }}</td>
                    <td class="text-center">{{ $no_identificado->fecha->format('d/m/Y') }}</td>
                    <td class="text-right">{{ number_format($no_identificado->monto, 2) }}</td>
                    <td class="text-left">{{ $no_identificado->no_deposito }}</td>
                    <td>{{ $no_identificado->identificado }}</td>
                    <td class="text-center">{{ $no_identificado->fecha_identificado->year == '-0001' ? '---' : $no_identificado->fecha_identificado->format('d/m/Y') }}</td>
                </tr>
            </table>

            <a href="{{ action('NoIdentificadoController@edit', $no_identificado->id) }}" class="btn btn-sm btn-primary">Editar</a>
            @if($no_identificado->identificado == 0)
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalBorrarNoIdentificado">Borrar</button>
            @endif

        </div>
    </div>
@stop
