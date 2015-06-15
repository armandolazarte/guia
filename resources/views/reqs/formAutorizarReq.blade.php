@extends('layouts.theme')

@section('content')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)

        {{-- Acciones Unidad de Presupuesto --}}
        {{--@if($acciones_presu)--}}
            {{--@include('reqs.accionesPresuReq', array('req' => $req))--}}
        {{--@endif--}}

        <div class="row">
            <div class="col-sm-12">
                <table class="table-bordered">
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
                                    <a href="{{ action('ArticulosController@edit', array($req->id, $articulo->id)) }}">{{ $articulo->articulo }}</a>
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
            </div>
        </div>
    @endif
@stop
