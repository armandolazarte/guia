<table class="table table-bordered">
    @if($solicitud->tipo_solicitud == "Vale")
        <thead><tr><th>Objetivo</th> <th>Monto</th></tr></thead>
        @foreach($solicitud->objetivos as $obj)
            <tr>
                <td>
                    @if($solicitud->estatus == "")
                        <a href="{{ action('SolicitudRecursosController@edit', array($solicitud->id, $obj->id)) }}">{{ $obj->objetivo }} {{ $obj->d_objetivo }}</a>
                    @else
                        {{ $obj->objetivo }}
                    @endif
                </td>
                <td>{{ $obj->pivot->monto }}</td>
            </tr>
        @endforeach
    @else
        <thead><tr><th>RM - Cuenta de Gasto</th> <th>Monto</th></tr></thead>
        @foreach($solicitud->rms as $rm)
            <tr>
                <td>
                    @if($solicitud->estatus == "")
                        <a href="{{ action('SolicitudRecursosController@edit', array($solicitud->id, $rm->id)) }}">{{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} {{ $rm->cog->d_cog }}</a>
                    @else
                        {{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} {{ $rm->cog->d_cog }}
                    @endif
                </td>
                <td>{{ $rm->pivot->monto }}</td>
            </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td></td>
        </tr>
    @endif
</table>