<table class="table table-hover table-condensed">
    <tr>
        <td>Solicitud No.</td>
        <td>{{ $solicitud->id }}</td>
    </tr>
    <tr>
        <td>Tipo de Solicitud</td>
        <td>{{ $solicitud->tipo_solicitud }}</td>
    </tr>
    <tr>
        <td>Proyecto</td>
        <td>{{ $solicitud->proyecto->proyecto }} {{ $solicitud->proyecto->d_proyecto }}</td>
    </tr>
    <tr>
        <td>URG</td>
        <td>{{ $solicitud->urg->urg }} {{ $solicitud->urg->d_urg }}</td>
    </tr>
    <tr>
        <td>Beneficiario</td>
        <td>{{ $solicitud->benef->benef }}</td>
    </tr>
    <tr>
        <td>No. Oficio</td>
        <td>{{ $solicitud->no_documento }}</td>
    </tr>
    <tr>
        <td>Concepto</td>
        <td>{{ $solicitud->concepto }}</td>
    </tr>
    <tr>
        <td>Observaciones</td>
        <td>{{ $solicitud->obs }}</td>
    </tr>
    <tr>
        <td>Monto Total</td>
        <td>{{ number_format($solicitud->monto,2) }}</td>
    </tr>
    <tr>
        <td>Viáticos</td>
        <td>{{ !empty($solicitud->viaticos) ? 'Pago de Viáticos' : '' }}</td>
    </tr>
</table>
