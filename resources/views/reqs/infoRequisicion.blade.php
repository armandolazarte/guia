@extends('layouts.base')

@section('contenido')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Cuenta de Gasto / Rec. Material</th>
                    <th>Costo Unitario</th>
                    <th>Sub-Total</th>
                    <th>Total (Incluye IVA)</th>
                    <th>Alta</th>
                </tr>
            </thead>
            @foreach($articulos as $articulo)
            <tr>
                <td>
                    @if($req->estatus == "")
                        <a href="{{ action('ArticulosController@edit', array($articulo->id)) }}">{{ $articulo->articulo }}</a>
                    @else
                        {!! $articulo->articulo !!}
                    @endif
                </td>
                <td>{!! $articulo->cantidad !!}</td>
                <td>{!! $articulo->unidad !!}</td>
                <td>
                    @if(!empty($articulo->rm_id))
                        {{-- @todo Obtener RM y Cuenta --}}
                    @else
                        <i>No asignado</i>
                    @endif
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </table>
    @endif


    @if($req->estatus == "")
        <a href="{{ action('ArticulosController@create', array($req->id)) }}">Agregar Artículo</a>
    @endif
@stop