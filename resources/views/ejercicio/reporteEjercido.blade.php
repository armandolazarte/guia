@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered table-compact table-striped table-hover">
                <tr>
                    {{--<th>ID</th>--}}
                    <th>Cuenta Bancaria</th>
                    <th>Poliza/Cheque</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Cuenta Clasificadora</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Estatus</th>
                    <th>Respnosable</th>
                </tr>

                @foreach($ejercido as $egreso)
                    <tr>
                        <td>{{ $egreso->cuentaBancaria->cuenta_bancaria }}</td>
                        <td>
                            <a href="{{ action('EgresosController@show', $egreso->id) }}">
                                @if(!empty($egreso->cheque))
                                    Ch. {{ $egreso->cheque }}
                                @else
                                    Pol. {{ $egreso->poliza }}
                                @endif
                            </a>
                        </td>
                        <td>{{ $egreso->fecha_info }}</td>
                        <td>{{ $egreso->benef->benef }}</td>
                        <td>{{ $egreso->cuenta->cuenta }}</td>
                        <td>{{ $egreso->concepto }}</td>
                        <td class="text-right">{{ number_format($egreso->monto, 2) }}</td>
                        <td>{{ $egreso->estatus }}</td>
                        <td>{{ $egreso->user->nombre }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6"></td>
                    <td class="text-right">{{ number_format($ejercido->sum('monto'), 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
@stop

