<table class="table table-bordered table-hover table-condensed">
    <tr>
        @if($accion == 'agregar-docs')
            <th>Agregar</th>
        @elseif($accion == 'recibir-docs')
            <th>Recibir</th>
        @endif
        <th>Cuenta Bancaria</th>
        <th>Poliza/Cheque</th>
        <th>Beneficiario</th>
        <th>Cuenta Clasificadora</th>
        <th>Monto</th>
        <th>Estatus</th>
    </tr>
    @foreach($documentos as $egreso)
        <tr id="egreso-{{ $egreso->id }}">

            @if($accion == 'agregar-docs')
                <td>
                    {!! Form::open(array('data-remote','action' => 'RelacionInternaDocController@store')) !!}
                    {!! Form::hidden('doc_id', $egreso->id) !!}
                    {!! Form::hidden('doc_type', 'Egreso') !!}
                    {!! Form::hidden('rel_interna_id', $rel_interna->id) !!}
                    {!! Form::submit('+' , array('class' => 'btn btn-sm btn-success')) !!}
                    {!! Form::close() !!}
                </td>
            @elseif($accion == 'recibir-docs')
                <td>
                    {!! Form::checkbox('docs[]', $egreso->id) !!}
                </td>
            @endif

            <td>{{ $egreso->cuentaBancaria->cuenta_bancaria }}</td>
            <td>
            @if(!empty($egreso->cheque))
                Ch. {{ $egreso->cheque }}
            @else
                Pol. {{ $egreso->poliza }}
            @endif

            </td>
            <td>{{ $egreso->benef->benef }}</td>
            <td>{{ $egreso->cuenta->cuenta }}</td>
            <td class="text-right">{{ number_format($egreso->monto, 2) }}</td>
            <td>{{ $egreso->estatus }}</td>

        </tr>
    @endforeach

</table>
@if($accion == 'agregar-docs')
{!! $documentos->render() !!}
@endif
