@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('cuadro.modalCancelarCuadro')

            <a href="{{ action('RequisicionController@show', $req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            <a class="btn btn-primary btn-sm" href="{{ action('CuadroController@cuadroPdf', $cuadro_id) }}" role="button" target="_blank">Imprimir</a>

            <!-- Formulario para terminar Cuadro Comparativo -->
            {!! Form::open(array('action' => array('CuadroController@update', $cuadro_id), 'method' => 'patch')) !!}
            {!! Form::hidden('id', $cuadro_id) !!}
            {!! Form::hidden('accion', 'Terminar') !!}
            {!! Form::submit('Terminar Cuadro', array('class' => 'btn btn-primary btn-sm')) !!}
            {!! Form::close() !!}

            <!-- Formulario para reanudar Cuadro Comparativo -->
            @if($req->estatus == 'Pagada' || $req->estatus == 'Autorizada')
                <button class="btn btn-primary btn-sm" disabled="disabled">Reanudar Cuadro</button>
            @else
                {!! Form::open(array('action' => array('CuadroController@update', $cuadro_id), 'method' => 'patch')) !!}
                {!! Form::hidden('id', $cuadro_id) !!}
                {!! Form::hidden('accion', 'Reanudar') !!}
                {!! Form::submit('Reanudar Cuadro', array('class' => 'btn btn-primary btn-sm')) !!}
                {!! Form::close() !!}
            @endif

            <!-- Formulario para cancelar Cuadro Comparativo -->
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalCancelarCuadro"{{ $req->estatus == 'Pagada' || $req->estatus == 'Autorizada' ? ' disabled="disabled"' : '' }}>Cancelar Cuadro Comparativo</button>

            <table class="table table-bordered">
                <tr>
                    @if(empty($req->tipo_cambio))
                        <td>Cotización en Pesos Mexicanos</td>
                    @else
                        <td>
                            Tipo de Cambio: {{ number_format($req->tipo_cambio, 2) }}
                            Moneda: {{ $req->moneda }}
                        </td>
                    @endif
                </tr>
            </table>

            <table class="table table-bordered">
                <thead>
                <th>Artículo</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                @foreach($cotizaciones as $cotizacion)
                    <th>{{ $cotizacion->benef->benef }}</th>
                @endforeach
                <th>IVA</th>
                <th>No Cotizado</th>
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
                        <td class="text-center">
                            @if($articulo->no_cotizado == 1)
                                <span class="glyphicon glyphicon-remove"></span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-right" colspan="3">Vigencia</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{{ $cotizacion->vigencia }}</td>
                    @endforeach
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="3">Garantía</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{{ $cotizacion->garantia }}</td>
                    @endforeach
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
@stop
