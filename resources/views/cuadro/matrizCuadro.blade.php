@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
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
                                {{-- Selección y Monto --}}
                            </td>
                        @endforeach
                        <td>
                            {{ $articulo->impuesto }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    {{-- Vigencia --}}
                </tr>
                <tr>
                    {{-- Garantía --}}
                </tr>
            </table>
        </div>
    </div>
@stop
