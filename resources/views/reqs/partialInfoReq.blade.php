
<table class="table table-condensed table-bordered">
    <tr>
        <td>Requisición No. {{ $req->req }}</td>
        <td>Fecha: {{ $req->fecha_req }}</td>
    </tr>
    <tr>
        <td colspan="2">Etiqueta: {{ $req->etiqueta }}</td>
    </tr>
    <tr>
        <td colspan="2">Proyecto: {{ $req->proyecto->proyecto }} - {{ $req->proyecto->d_proyecto }}</td>
    </tr>
    <tr>
        <td colspan="2">Fondo: {{ $req->proyecto->fondos[0]->fondo }} - {{ $req->proyecto->fondos[0]->d_fondo }}</td>
    </tr>
    <tr>
        <td colspan="2">URG de Aplicación: {{ $req->urg->urg }} - {{ $req->urg->d_urg }}</td>
    </tr>
    <tr>
        <td>Solicita:</td>
        <td>Lugar de Entrega: {{ $req->lugar_entrega }}</td>
    </tr>
    <tr>
        <td colspan="2">Observaciones: <br> {{ $req->obs }}</td>
    </tr>
</table>
