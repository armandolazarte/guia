
<table class="table table-condensed table-bordered">
    <tr>
        <td>Solicitud No. {{ $prereq->sol }}</td>
        <td>Estatus: {{ $prereq->estatus }}</td>
        <td>Fecha: {{ $prereq->fecha }}</td>
    </tr>
    <tr>
        <td colspan="3">Etiqueta: {{ $prereq->etiqueta }}</td>
    </tr>
    <tr>
        <td colspan="3">URG de Aplicación: {{ $prereq->urg->urg }} - {{ $prereq->urg->d_urg }}</td>
    </tr>
    <tr>
        <td>Solicita: {{ $prereq->user->nombre }}</td>
        <td colspan="2">Lugar de Entrega: {{ $prereq->lugar_entrega }}</td>
    </tr>
    <tr>
        <td colspan="3">Observaciones: <br> {{ $prereq->obs }}</td>
    </tr>
</table>
