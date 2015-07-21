@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ action('RequisicionController@show', $cuadro->req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            @include('partials.formErrors')
            {!! Form::open(array('action' => ['MatrizCuadroController@update', $cuadro->id], 'method' => 'patch')) !!}

            <div class="form-group">
                {!! Form::label('tipo_cambio', 'Tipo de Cambio', array('class' => 'col-sm-1 control-label')) !!}
                <div class="col-sm-1">
                    {!! Form::text('tipo_cambio', number_format($tipo_cambio, 2), ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::select('moneda', ['' => 'Peso Mexicano', 'USD' => 'Dolar', 'CAD' => 'Dolar Canadiense', 'Euros' => 'Euros', 'Libras' => 'Libras'], $moneda, ['class' => 'form-control']) !!}
                </div>
            </div>

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
                        @foreach($cotizaciones as $cotizacion)
                            <td>
                                @if($articulo->cotizaciones()->get()->contains($cotizacion->id)) {{-- //Verifica que exista pivote --}}
                                    {!! Form::radio('sel_'.$articulo->id, $cotizacion->id, $articulo->cotizaciones()->whereCotizacionId($cotizacion->id)->first()->pivot->sel) !!}
                                    {!! Form::text('costo_'.$articulo->id.'_'.$cotizacion->id, $articulo->cotizaciones()->whereCotizacionId($cotizacion->id)->first()->pivot->costo) !!}
                                @else
                                    {!! Form::radio('sel_'.$articulo->id, $cotizacion->id) !!}
                                    {!! Form::text('costo_'.$articulo->id.'_'.$cotizacion->id, '') !!}
                                @endif
                                {{-- dd($articulo->cotizaciones()->whereCotizacionId($cotizacion->id)->first()->pivot->costo) --}}
                            </td>
                        @endforeach
                        <td>
                            {!! Form::text('impuesto_'.$articulo->id, $articulo->impuesto) !!}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Vigencia</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{!! Form::text('vigencia_'.$cotizacion->id, $cotizacion->vigencia) !!}</td>
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">Garantía</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{!! Form::text('garantia_'.$cotizacion->id, $cotizacion->garantia) !!}</td>
                    @endforeach
                    <td></td>
                </tr>
            </table>

            {!! Form::hidden('req_id', $cuadro->req_id) !!}
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
