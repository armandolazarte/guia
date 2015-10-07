@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                <tr>
                    <td class="text-center">Cheque</td>
                    <td class="text-center">Fecha Emisión</td>
                    <td class="text-center">Cuenta</td>
                    <td class="text-center">Beneficiario</td>
                    <td class="text-center">Monto</td>
                    <td class="text-center">Fecha Cobro</td>
                    <td class="text-center">Fecha Cancelación</td>
                </tr>
                </thead>
                <tbody>
                @foreach($circulacion as $circ)
                    <tr>
                        <td>Cheque {{ $circ->cheque }}</td>
                        <td class="text-right">{{ $circ->fecha }}</td>
                        <td>{{ $circ->cuenta->cuenta }}</td>
                        <td>{{ $circ->benef->benef }}</td>
                        <td class="text-right">{{ number_format($circ->monto, 2) }}</td>
                        <td class="text-center">{{ $circ->fecha_cobro }}</td>
                        <td class="text-center">{{ $circ->deleted_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
