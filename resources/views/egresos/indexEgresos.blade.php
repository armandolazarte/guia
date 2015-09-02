@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered table-compact table-hover">
                <tr>
                    {{--<th>ID</th>--}}
                    <th>Cuenta Bancaria</th>
                    <th>Poliza/Cheque</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Cuenta Clasificadora</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Doc. Origen</th>
                    <th>Estatus</th>
                    <th>Respnosable</th>
                    @if($acciones_presupuesto)
                        <th>Imprimir</th>
                    @endif
                </tr>

                @foreach($egresos as $egreso)
                    <tr>
                        {{--<td>{{ $egreso->id }}</td>--}}
                        <td><a href="{{ action('EgresosController@show', $egreso->id) }}">{{ $egreso->cuentaBancaria->cuenta_bancaria }}</a></td>
                        @if(!empty($egreso->cheque))
                            <td>Ch. {{ $egreso->cheque }}</td>
                        @else
                            <td>Pol. {{ $egreso->poliza }}</td>
                        @endif
                        <td>{{ $egreso->fecha_info }}</td>
                        <td>{{ $egreso->benef->benef }}</td>
                        <td>{{ $egreso->cuenta->cuenta }}</td>
                        @if($acciones_presupuesto)
                            @if(!empty($egreso->concepto))
                                <td><a href="{{ action('EgresosController@edit', $egreso->id) }}">{{ $egreso->concepto }}</a></td>
                            @else
                                <td><a href="{{ action('EgresosController@edit', $egreso->id) }}">EDITAR CONCEPTO</a></td>
                            @endif
                        @else
                            <td>{{ $egreso->concepto }}</td>
                        @endif
                        <td class="text-right">{{ number_format($egreso->monto, 2) }}</td>
                        <td>
                            @if(count($egreso->ocs) > 0)
                                @foreach($egreso->ocs as $oc)
                                    OC<br>{{ $oc->oc }}
                                @endforeach
                            @elseif(count($egreso->solicitudes) > 0)
                                @foreach($egreso->solicitudes as $solicitud)
                                    {{ $solicitud->id }}<br>{{ $solicitud->tipo_solicitud }}
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $egreso->estatus }}</td>
                        <td>{{ $egreso->user->nombre }}</td>
                        @if($acciones_presupuesto)
                            <td><a href="{{ action('EgresosController@chequeRtf', $egreso->id) }}" target="_blank">Imprimir</a></td>
                        @endif
                    </tr>
                @endforeach

            </table>

            {!! $egresos->render() !!}

        </div>
    </div>
@stop

