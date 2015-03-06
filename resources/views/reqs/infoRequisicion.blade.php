@extends('layouts.theme')

@section('content')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)
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
    @endif


    @if($req->estatus == "")
        <a class="btn btn-primary btn-sm" href="{{ action('ArticulosController@create', array($req->id)) }}">Agregar Artículo</a>
    @endif

    @if($req->estatus == '')
        {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
        <input type="hidden" name="accion" value="Enviar">
        <button type="submit" class="btn btn-success">Enviar a Adquisiciones</button>
        {!! Form::close() !!}
    @endif

    @if($req->estatus == 'Enviada')
        {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
        <input type="hidden" name="accion" value="Recuperar">
        <button type="submit" class="btn btn-warning">Recuperar</button>
        {!! Form::close() !!}
    @endif

@stop