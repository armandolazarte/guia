
<table class="table table-condensed table-bordered">
    <tr>
        <td>Requisición No. {{ $req->req }}</td>
        <td>Estatus: {{ $req->estatus }}</td>
        <td>Fecha: {{ $req->fecha_info }}</td>
    </tr>
    <tr>
        <td colspan="3">Etiqueta: {{ $req->etiqueta }}</td>
    </tr>
    <tr>
        <td colspan="3">Proyecto: {{ $req->proyecto->proyecto }} - {{ $req->proyecto->d_proyecto }}</td>
    </tr>
    <tr>
        <td colspan="3">Fondo: {{ $req->proyecto->fondos[0]->fondo }} - {{ $req->proyecto->fondos[0]->d_fondo }}</td>
    </tr>
    <tr>
        <td colspan="3">URG de Aplicación: {{ $req->urg->urg }} - {{ $req->urg->d_urg }}</td>
    </tr>
    <tr>
        <td>Solicita: {{ $solicita->nombre }}</td>
        <td colspan="2">Lugar de Entrega: {{ $req->lugar_entrega }}</td>
    </tr>
    <tr>
        <td colspan="3">Observaciones: <br> {{ $req->obs }}</td>
    </tr>
</table>
