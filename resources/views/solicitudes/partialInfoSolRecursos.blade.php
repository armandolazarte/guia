<table class="table table-bordered">
    @if(count($solicitud->objetivos) > 0)
        <thead><tr><th>Objetivo</th> <th>Monto</th></tr></thead>
        @foreach($solicitud->objetivos as $obj)
            <tr>
                <td>
                    @if($solicitud->estatus == "" || array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false)
                        <a href="{{ action('SolicitudRecursosController@edit', array($solicitud->id, $obj->id)) }}">{{ $obj->objetivo }} {{ $obj->d_objetivo }}</a>
                    @else
                        {{ $obj->objetivo }}
                    @endif
                </td>
                <td class="text-right">{{ number_format($obj->pivot->monto,2) }}</td>
            </tr>
        @endforeach
    @else
        <thead><tr><th>RM - Cuenta de Gasto</th> <th>Monto</th></tr></thead>
        @foreach($solicitud->rms as $rm)
            <tr>
                <td>
                    @if($solicitud->estatus == "" || array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false)
                        <a href="{{ action('SolicitudRecursosController@edit', array($solicitud->id, $rm->id)) }}">{{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} {{ $rm->cog->d_cog }}</a>
                    @else
                        {{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} {{ $rm->cog->d_cog }}
                    @endif
                </td>
                <td class="text-right">{{ number_format($rm->pivot->monto,2) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>TOTAL</td>
            <td class="text-right"><b>{{ number_format($solicitud->monto,2) }}</b></td>
        </tr>
    @endif
</table>