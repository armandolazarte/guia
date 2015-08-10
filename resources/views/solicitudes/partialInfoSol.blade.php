<table class="table table-condensed table-bordered">
    <tr>
        <td>Solicitud No. {{ $solicitud->id }}</td>
        <td>Tipo de Solicitud: {{ $solicitud->tipo_solicitud }}</td>
        <td>Fecha: {{ $solicitud->fecha_info }}</td>
    </tr>
    <tr>
        <td>No. Oficio: {{ $solicitud->no_documento }}</td>
        <td>Estatus: {{ $solicitud->estatus }}</td>
        <td>
            Viáticos:
            @if(!empty($solicitud->viaticos))
                <span class="glyphicon glyphicon-ok"></span>
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3">Proyecto: {{ $solicitud->proyecto->proyecto }} - {{ $solicitud->proyecto->d_proyecto }}</td>
    </tr>
    <tr>
        <td colspan="3">URG de Aplicación: {{ $solicitud->urg->urg }} - {{ $solicitud->urg->d_urg }}</td>
    </tr>
    <tr>
        <td colspan="3">Beneficiario: {{ $solicitud->benef->benef }}</td>
    </tr>
    <tr>
        <td colspan="3">Concepto: <br> {{ $solicitud->concepto }}</td>
    </tr>
    <tr>
        <td colspan="3">Observaciones: <br> {{ $solicitud->obs }}</td>
    </tr>
    <tr>
        <td colspan="3">Monto Total: {{ number_format($solicitud->monto,2) }}</td>
    </tr>
</table>
