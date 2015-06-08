{{-- Recibir modo de tabla: Condensado || Extendida --}}

<table class="table table-bordered table-condensed">
    <tr>
        <th>BMS</th>
        <th>Objetivo</th>
        <th>RM - Cta. de Gasto (i)</th>
        <th>Presupuestado</th>
        @if($modo_tabla == 'ext')
            <th>Depositado</th>{{-- Oculto para URG --}}
        @endif
        <th>Compensado*</th>
        <th>Depositado</th>
        @if($modo_tabla == 'ext')
            <th>Ejercido*</th>{{-- Cheques + Egresos + Retenciones --}}
        @else
            <th>Ejercido</th>
            <th>Reintegro DF</th>{{-- Cheques + Devoluciones directas --}}
        @endif
        <th>Reservado</th>{{-- Sol. + Req. --}}
        <th>Comprobado Vales</th>
        <th>Saldo</th>
        @if($modo_tabla == 'ext')
            <th>Saldo por Depositar</th>
        @endif
    </tr>

    @foreach($rms as $rm)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    @endforeach

</table>