@extends('layouts.theme')

@section('content')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)

        {{-- Acciones Unidad de Suministros --}}
        @if($acciones_suministros)
            @include('reqs.accionesSuministros', array('req' => $req))
        @endif

        {{-- Acciones Unidad de Presupuesto --}}
        @if($acciones_presu)
            @include('reqs.accionesPresuReq', array('req' => $req))
        @endif

    <div class="row">
        <div class="col-sm-12">
        <table class="table table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">Artículo</th>
                    <th rowspan="2" class="text-center">Cantidad</th>
                    <th rowspan="2" class="text-center">Unidad</th>
                    <th rowspan="2" class="text-center">Cuenta de Gasto / Rec. Material <br>/ Monto Autorizado</th>
                    <th colspan="3" class="text-center">Cotizado (Unidad de Suministros)</th>
                    <th rowspan="2" class="text-center">Alta</th>
                    <th rowspan="2" class="text-center">No Cotizado</th>
                </tr>
            <tr>
                <th>Costo Unitario</th>
                <th>Sub-Total</th>
                <th>Total (Incluye IVA)</th>
            </tr>
            </thead>
            @foreach($articulos as $articulo)
                @if($articulo->rms->count() > 0)
                    <tr class="bg-success">
                @elseif($articulo->no_cotizado == 1)
                    <tr class="bg-danger">
                @elseif(count($articulo->cotizaciones) > 0)
                    <tr class="bg-info">
                @else
                    <tr class="bg-warning">
                @endif

                <td>
                    @if($req->estatus == "")
                        <a href="{{ action('ArticulosController@edit', array($req->id, $articulo->id)) }}">{{ $articulo->articulo }}</a>
                    @else
                        {!! $articulo->articulo !!}
                    @endif
                </td>
                <td>{!! $articulo->cantidad !!}</td>
                <td>{!! $articulo->unidad !!}</td>
                <td class="text-center">
                    @if($articulo->rms->count() > 0)
                        @foreach($articulo->rms as $rm)
                            {{ $rm->cog->cog }} / {{ $rm->rm }} / $ {{ number_format($rm->pivot->monto, 2) }}
                            @if($articulo->rms->count() > 1)
                                <br>
                            @endif
                        @endforeach
                    @else
                        <i>No asignado</i>
                    @endif
                </td>
                @if(count($articulo->cotizaciones) > 0)
                    <td class="text-right">
                        {{ number_format($articulo->monto_cotizado, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($articulo->sub_total, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($articulo->monto_total, 2) }}
                    </td>
                @else
                    <td class="text-center" colspan="3">Por Cotizar</td>
                @endif
                <td class="text-center">
                    @if($articulo->inventariable == 1)
                        <span class="glyphicon glyphicon-ok"></span>
                    @endif
                </td>
                <td class="text-center">
                    @if($articulo->no_cotizado == 1)
                        <span class="glyphicon glyphicon-remove"></span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

            @include('reqs.partialAsignacionRms')

        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <div class="btn-group btn-group-sm" role="group">
                @if($req->estatus == "")
                    <a class="btn btn-primary" href="{{ action('ArticulosController@create', array($req->id)) }}">Agregar Artículo</a>
                    <a class="btn btn-primary" href="{{ action('RequisicionController@edit', array($req->id)) }}">Editar Información</a>
                @endif
                <a class="btn btn-primary" href="{{ action('RequisicionController@formatoPdf', array($req->id)) }}" target="_blank">Formato (PDF)</a>
            </div>
        </div>

        <div class="col-sm-6">
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