@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ action('RequisicionController@show', $req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            @include('partials.formErrors')
            {!! Form::open(array('action' => 'MatrizCuadroController@store')) !!}

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
                                {!! Form::radio('sel_'.$articulo->id, $cotizacion->id) !!}
                                {!! Form::text('costo_'.$articulo->id.'_'.$cotizacion->id, '') !!}
                            </td>
                        @endforeach
                        <td>
                            {!! Form::text('impuesto_'.$articulo->id, '16') !!}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Vigencia</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{!! Form::text('vigencia_'.$cotizacion->id, '') !!}</td>
                    @endforeach
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">Garantía</td>
                    @foreach($cotizaciones as $cotizacion)
                        <td>{!! Form::text('garantia_'.$cotizacion->id, '') !!}</td>
                    @endforeach
                    <td></td>
                </tr>
            </table>

            {!! Form::hidden('req_id', $req_id) !!}
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
