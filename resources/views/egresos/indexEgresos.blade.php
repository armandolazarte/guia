@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {!! $egresos->render() !!}

            <table class="table table-bordered table-compact table-hover">
                <tr>
                    {{--<th>ID</th>--}}
                    <th>Cuenta Bancaria</th>
                    <th>Cheque/Póliza</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Proyecto / Cuenta Clasificadora</th>
                    <th>Fondo</th>
                    <th>Doc. Origen</th>
                    <th>ID AFIN</th>
                    <th>Estatus</th>
                    <th>Respnosable</th>
                    @if($acciones_presupuesto)
                        <th>Imprimir</th>
                    @endif
                </tr>

                @foreach($egresos as $egreso)
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
                        <td class="text-center">
                            @if($egreso->cuenta_id == 1 || $egreso->cuenta_id == 2)
                                @foreach($egreso->proyectos as $proyecto)
                                    {{ $proyecto->proyecto }}
                                @endforeach
                            @else
                                {{ $egreso->cuenta->cuenta }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($egreso->cuenta_id == 1 || $egreso->cuenta_id == 2)
                                @foreach($egreso->proyectos as $proyecto)
                                    {{ $proyecto->fondos[0]->fondo }}
                                @endforeach
                            @else
                                ---
                            @endif
                        </td>
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
                        <td>
                            ID AFIN
                        </td>
                        <td>{{ $egreso->estatus }}</td>
                        <td>{{ $egreso->user->nombre }}</td>
                        @if($acciones_presupuesto)
                            <td><a href="{{ action('EgresosController@chequeRtf', $egreso->id) }}" target="_blank">Imprimir</a></td>
                        @endif
                    </tr>
                @endforeach

            </table>

        </div>
    </div>
@stop

