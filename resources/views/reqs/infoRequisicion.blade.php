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

    <div class="row">
        <div class="col-sm-3">
            <div class="btn-group btn-group-sm" role="group">
                @if($req->estatus == "")
                    <a class="btn btn-primary" href="{{ action('ArticulosController@create', array($req->id)) }}">Agregar Artículo</a>
                @endif
                <a class="btn btn-primary" href="{{ action('RequisicionController@formatoPdf', array($req->id)) }}" target="_blank">Formato (PDF)</a>
            </div>
        </div>

        <div class="col-sm-6 col-sm-offset-1">
            <div class="row">
                @if($req->estatus == '' && count($articulos) > 0)
                <div class="col-md-4">
                    {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Enviar">
                    <button class="btn btn-success" type="submit">Enviar a Adquisiciones</button>
                    {!! Form::close() !!}
                </div>
                @endif

                @if($req->estatus == 'Enviada')
                    <div class="col-md-4">
                        {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                        <input type="hidden" name="accion" value="Recuperar">
                        <button type="submit" class="btn btn-warning">Recuperar</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop