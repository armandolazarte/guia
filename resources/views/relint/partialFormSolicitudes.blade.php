
<table class="table table-bordered table-hover table-condensed">
    <tr>
        @if($accion == 'agregar-docs')
            <th>Agregar</th>
        @elseif($accion == 'recibir-docs')
            <th>Recibir</th>
        @endif
        <th class="text-center">Solicitud</th>
        <th class="text-center">Beneficiario</th>
        <th class="text-center">Monto</th>
        <th class="text-center">Proyecto</th>
        <th class="text-center">Tipo</th>
        <th class="text-center">Estatus</th>
    </tr>
    @foreach($documentos as $solicitud)
        <tr id="solicitud-{{ $solicitud->id }}">

            @if($accion == 'agregar-docs')
                <td>
                    {!! Form::open(array('data-remote','action' => 'RelacionInternaDocController@store')) !!}
                    {!! Form::hidden('doc_id', $solicitud->id) !!}
                    {!! Form::hidden('doc_type', 'Solicitud') !!}
                    {!! Form::hidden('rel_interna_id', $rel_interna->id) !!}
                    {!! Form::submit('+' , array('class' => 'btn btn-sm btn-success')) !!}
                    {!! Form::close() !!}
                </td>
            @elseif($accion == 'recibir-docs')
                <td>
                    {!! Form::checkbox('docs[]', $solicitud->id) !!}
                </td>
            @endif
                <td class="text-center">{{ $solicitud->id }}</td>
                <td>{{ $solicitud->benef->benef }}</td>
                <td class="text-right">{{ number_format($solicitud->monto, 2) }}</td>
                <td class="text-center">{{ $solicitud->proyecto->proyecto }}</td>
                <td>{{ $solicitud->tipo_solicitud }}</td>
                <td>{{ $solicitud->estatus }}</td>
        </tr>
    @endforeach

</table>
