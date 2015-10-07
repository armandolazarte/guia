@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                <tr>
                    <td class="text-center">Póliza/Cheque</td>
                    <td class="text-center">Fecha</td>
                    <td class="text-center">Cuenta</td>
                    <td class="text-center">Beneficiario</td>
                    <td class="text-center">Cargo</td>
                    <td class="text-center">Abono</td>
                    <td class="text-center">Saldo</td>
                </tr>
                </thead>
                <tbody>
                @foreach($auxiliar_registros as $k => $aux)
                    <tr>
                        <td>
                            @if(class_basename($aux) == 'Egreso')
                                @if(!empty($aux->cheque))
                                    Cheque {{ $aux->cheque }}
                                @else
                                    Egreso {{ $aux->poliza }}
                                @endif
                            @elseif(class_basename($aux) == 'Ingreso')
                                Ingreso {{ $aux->poliza }}
                            @endif
                        </td>
                        <td>{{ $aux->fecha }}</td>
                        <td>{{ $aux->cuenta->cuenta }}</td>
                        <td>
                            @if(class_basename($aux) == 'Egreso')
                                {{ $aux->benef->benef }}
                            @else

                            @endif
                        </td>
                        <td class="text-right">
                            @if(class_basename($aux) == 'Egreso' && $aux->cuenta->cuenta != 'CANCELADO')
                                {{ number_format($aux->monto, 2) }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if(class_basename($aux) == 'Ingreso')
                                {{ number_format($aux->monto, 2) }}
                            @elseif(class_basename($aux) == 'Egreso' && $aux->cuenta->cuenta == 'CANCELADO')
                                {{ number_format($aux->monto, 2) }} {{ $aux->deleted_at }}
                            @endif
                        </td>
                        <td class="text-right"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
