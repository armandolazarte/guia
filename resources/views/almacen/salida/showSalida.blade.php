@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID Salida</th>
                    <th>Fecha de salida</th>
                    <th>Documento Origen</th>
                    <th>URG</th> <th>Comentarios</th>
                    <th>Usuario</th>
                </tr>
                </thead>
                <tr>
                    <td>{{ $salida->id }}</td>
                    <td>{{ $salida->fecha_salida }}</td>
                    <td>{{ $salida->entrada->ref_tipo }} {{ $salida->entrada->ref }}</td>
                    <td>{{ $salida->urg->urg }}</td>
                    <td>{{ $salida->cmt }}</td>
                    <td>{{ $salida->responsable }}</td>
                </tr>
            </table>

            <table class="table table-bordered">
                <thead><tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Unidad</th>
                </tr></thead>
                @foreach ($salida->articulos as $art)
                    <tr>
                        <td>
                            {{ $art->articulo }}
                        </td>
                        <td>
                            {{ $art->pivot->cantidad }}
                        </td>
                        <td>{{ $art->costo }}</td>
                        <td>{{ $art->impuesto }}</td>
                        <td>{{ $art->monto }}</td>
                        <td>{{ $art->unidad }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop