<div class="panel panel-default">
    <div class="panel-heading">Información General de la Requisición</div>
    <div class="panel-body">
        <table class="table table-condensed table-bordered">
            <tr>
                <td>Requisición No. <b>{{ $req->req }}</b></td>
                <td>Estatus: <b>{{ $req->estatus }}</b></td>
                <td>Fecha: <b>{{ $req->fecha_info }}</b></td>
                <td>Responsable: <b>{{ $req->user->nombre or '' }}</b> Correo: <a href="mailto:{{ $req->user->email or '' }}">{{ $req->user->email or '' }}</a></td>
            </tr>
            <tr>
                <td colspan="4">Etiqueta: <b>{{ $req->etiqueta }}</b></td>
            </tr>
            <tr>
                <td colspan="4">Proyecto: <b>{{ $req->proyecto->proyecto }} - {{ $req->proyecto->d_proyecto }}</b></td>
            </tr>
            <tr>
                <td colspan="4">Fondo: <b>{{ $req->proyecto->fondos[0]->fondo }} - {{ $req->proyecto->fondos[0]->d_fondo }}</b></td>
            </tr>
            <tr>
                <td colspan="4">URG de Aplicación: <b>{{ $req->urg->urg }} - {{ $req->urg->d_urg }}</b></td>
            </tr>
            <tr>
                <td>Solicita: <b>{{ $solicita->nombre }}</b></td>
                <td colspan="3">Lugar de Entrega: <b>{{ $req->lugar_entrega }}</b></td>
            </tr>
            <tr>
                <td colspan="4">Observaciones: <br> {{ $req->obs }}</td>
            </tr>
        </table>
    </div>
</div>
