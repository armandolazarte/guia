<table class="table table-bordered">

    <tr>
        <td>Fondo: {{ $soldep->fondo->fondo }} {{ $soldep->fondo->d_fondo }}</td>
        <td>Monto a Transferir: $</td>
    </tr>
    <tr>
        <td>No. Solicitud de Depósito: {{ $soldep->id }}</td>
        <td>Monto Retenciones: $</td>
    </tr>
    <tr>
        <td>Fecha: {{ $soldep->fecha }}</td>
        <td>Monto Total: $</td>
    </tr>

</table>