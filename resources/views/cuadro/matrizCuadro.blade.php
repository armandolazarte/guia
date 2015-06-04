@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ action('RequisicionController@show', $req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            <!-- Formulario para terminar Cuadro Comparativo -->
            {!! Form::open(array('action' => array('CuadroController@update', $cuadro_id), 'method' => 'patch')) !!}
            {!! Form::hidden('id', $cuadro_id) !!}
            {!! Form::hidden('accion', 'Terminar') !!}
            {!! Form::submit('Terminar Cuadro', array('class' => 'btn btn-primary btn-sm')) !!}
            {!! Form::close() !!}

            <!-- Formulario para cancelar Cuadro Comparativo -->
            {!! Form::open(array('action' => array('CuadroController@update', $cuadro_id), 'method' => 'delete')) !!}
            {!! Form::submit('Cancelar Cuadro', array('class' => 'btn btn-danger btn-sm')) !!}
            {!! Form::close() !!}

            <table class="table table-bordered">
                <thead>
                <th>Artículo</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                @foreach($cotizaciones as $cotizacion)
                    <th>{{ $cotizacion->benef->benef }}</th>
                @endforeach
                <th>IVA</th>
                </thead>
                @foreach($articulos as $articulo)
                    <tr>
                        <td>{{ $articulo->articulo }}</td>
                        <td>{{ $articulo->unidad }}</td>
                        <td>{{ $articulo->cantidad }}</td>
                        @foreach($articulo->cotizaciones as $cot)
                            <td class="text-right">
                                {{ $cot->pivot->sel == 1 ? '*' : '' }} {{ $cot->pivot->costo }}
                            </td>
                        @endforeach
                        <td>
                            {{ $articulo->impuesto }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-right" colspan="3">Vigencia</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{{ $cotizacion->vigencia }}</td>
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="3">Garantía</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{{ $cotizacion->garantia }}</td>
                    @endforeach
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
@stop
