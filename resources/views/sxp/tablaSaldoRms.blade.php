{{-- Recibir modo de tabla: Condensada || Extendida --}}

@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered table-condensed table-hover">
                <tr>
                    <th>BMS</th>
                    <th>Objetivo</th>
                    <th>RM - Cta. de Gasto</th>
                    <th>Presupuestado</th>
                    @if($modo_tabla == 'extendida')
                        <th>Depositado</th>{{-- Oculto para URG --}}
                    @endif
                    <th>Compensado*</th>
                    @if($modo_tabla == 'condensada')
                        <th>Ejercido*</th>{{-- Cheques + Egresos + Retenciones --}}
                    @elseif($modo_tabla == 'extendida')
                        <th>Ejercido</th>
                        <th>Reintegro DF</th>{{-- Cheques + Devoluciones directas --}}
                    @endif
                    <th>Reservado*</th>{{-- Sol. + Req. --}}
                    <th>Comprobado Vales</th>
                    <th>Saldo</th>
                    @if($modo_tabla == 'extendida')
                        <th>Saldo por Depositar</th>
                    @endif
                </tr>

                @foreach($rms as $rm)
                    <tr>
                        <td></td>
                        <td>{{ $rm->objetivo->objetivo }}</td>
                        <td>
                            RM {{ $rm->rm }} - Cta. <span data-toggle="tooltip" data-placement="top" title="{{ $rm->cog->d_cog }}">{{ $rm->cog->cog }}</span>
                        </td>
                        <td class="text-right">{{ number_format($rm->monto,2) }}</td>
                        @if($modo_tabla == 'extendida')
                            <td></td>{{-- Depositado --}}
                        @endif
                        <td></td>{{-- Compensado --}}
                        @if($modo_tabla == 'condensada')
                            <td></td>{{-- Ejercido --}}
                        @elseif($modo_tabla == 'extendida')
                            <td></td>{{-- Ejercido --}}
                            <td></td>{{-- Reintegros DF --}}
                        @endif
                        <td></td>{{-- Reservado --}}
                        <td></td>{{-- Comprobado Vales --}}
                        <td></td>{{-- Saldo --}}
                        @if($modo_tabla == 'extendida')
                            <td></td>{{-- Saldo por Depositar --}}
                        @endif
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
