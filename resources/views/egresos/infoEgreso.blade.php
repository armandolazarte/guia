@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-condensed">
            <tr>
                <th>Cuenta Bancaria</th>
                <th>Poliza/Cheque</th>
                <th>Fecha</th>
                <th>Beneficiario</th>
                <th>Cuenta Clasificadora</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Estatus</th>
                <th>Respnosable</th>
                <th>Imprimir</th>
            </tr>
            <tr>
                <td>{{ $egreso->cuentaBancaria->cuenta_bancaria }}</td>
                @if(!empty($egreso->cheque))
                    <td>Ch. {{ $egreso->cheque }}</td>
                @else
                    <td>Pol. {{ $egreso->poliza }}</td>
                @endif
                <td>{{ $egreso->fecha }}</td>
                <td>{{ $egreso->benef->benef }}</td>
                <td>{{ $egreso->cuenta->cuenta }}</td>
                <td>{{ $egreso->concepto }}</td>
                <td class="text-right">{{ number_format($egreso->monto, 2) }}</td>
                <td>{{ $egreso->estatus }}</td>
                <td>{{ $egreso->user->nombre }}</td>
                <td><a href="{{ action('EgresosController@chequeRtf', $egreso->id) }}" target="_blank">Imprimir</a></td>
            </tr>
        </table>

        {{-- @todo Solo mostrar "Captura Cheque" en ciertos roles --}}
        {{--<a href="{{ action('EgresosController@create') }}">Capturar Cheque</a>--}}

        @include('partials.archivos.modalBorrarArchivo')
        <div class="panel panel-info">
            <div class="panel-heading">Archivos</div>
            <div class="panel-body">
                <div class="col-sm-8">
                    @include('partials.archivos.showFiles', array('documento_id' => $egreso->id, 'documento_type' => 'Guia\Models\Egreso'))
                </div>
                {{--<div class="col-sm-4">--}}
                    {{--@include('partials.archivos.formUpload', array('documento_id' => $egreso->id, 'documento_type' => 'Guia\Models\Egreso'))--}}
                {{--</div>--}}

            </div>
        </div>

    </div>
</div>
@stop
@section('js')
    @parent
    <script src="{{ asset('js/borrar-archivo-helper.js') }}"></script>
@stop
