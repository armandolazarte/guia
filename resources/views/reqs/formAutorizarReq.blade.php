@extends('layouts.theme')

@section('content')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)

        @include('reqs.accionesPresuReq', array('req' => $req))

        <div class="row">
            <div class="col-sm-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Asignación de RMs</div>
                    <div class="panel-body">

                        {!! Form::open(array('action' => 'AutorizarReqController@asignarRms', 'method' => 'patch', 'class' => 'form-horizontal')) !!}

                        {!! Form::select('rm_id', $arr_rms, null, array('class' => 'form-control')) !!}
                        <br>

                        <table class="table table-bordered table-hover table-condensed">
                            <thead>
                            <tr>
                                <th>Aplicar<br>COG/RM</th>
                                <th>Cuenta de Gasto / Rec. Material</th>
                                <th>Artículo</th>
                                <th>Cantidad</th>
                                <th>Costo Unitario</th>
                                <th>Alta</th>
                                <th>Sub-Total</th>
                                <th>Total (Incluye IVA)</th>
                                <th>TOTAL MXP</th>
                            </tr>
                            </thead>

                            @if(count($articulos_sin_rms) > 0)
                                @foreach($articulos_sin_rms as $articulo)
                                    <tr>
                                        <td class="text-center">
                                            {!! Form::checkbox('arr_articulo_id[]', $articulo->id) !!}
                                        </td>
                                        <td class="text-center">
                                            @if($articulo->rms->count() > 0)
                                                @foreach($articulo->rms as $rm)
                                                    {{ $rm->cog->cog }} / {{ $rm->rm }}
                                                @endforeach
                                            @else
                                                <i>No asignado</i>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $articulo->articulo }}
                                        </td>
                                        <td class="text-center">
                                            {{ $articulo->cantidad.' '.$articulo->unidad }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto_cotizado, 2) }}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('alta_'.$articulo->id, 1, $articulo->inventariable) !!}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->sub_total, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto_total, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="subtotal-sin-rms">
                                    <td colspan="8" class="text-right">Total no asignado</td>
                                    <td class="text-right">{{ number_format($articulos_sin_rms->sum('monto'), 2) }}</td>
                                </tr>
                            @endif

                            @foreach($rms_articulos as $rm)
                                @foreach($rm->articulos as $articulo)
                                    <tr class="bg-warning">
                                        <td class="text-center">
                                            {!! Form::checkbox('arr_articulo_id[]', $articulo->id) !!}
                                        </td>
                                        <td class="text-center">
                                            {{ $rm->cog->cog }} / {{ $rm->rm }}
                                        </td>
                                        <td>
                                            {{ $articulo->articulo }}
                                        </td>
                                        <td class="text-center">
                                            {{ $articulo->cantidad.' '.$articulo->unidad }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto_cotizado, 2) }}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('alta_'.$articulo->id, 1, $articulo->inventariable) !!}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->sub_total, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto_total, 2) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($articulo->monto, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr id="subtotal-rm-{{ $rm->rm }}" class="bg-info">
                                    <td colspan="8" class="text-right">Sub-Total Autorizado (Cuenta: {{ $rm->cog->cog }} - RM: {{ $rm->rm }})</td>
                                    <td class="text-right">{{ number_format($rm->articulos()->where('req_id', $req->id)->sum('articulo_rm.monto'), 2) }}</td>
                                </tr>
                            @endforeach
                            <tr id="total-autorizado" class="bg-success">
                                <td colspan="8" class="text-right">Total Autorizado</td>
                                <td class="text-right">{{ number_format($rms_articulos->sum(function ($rm) use ($req){ return $rm->articulos()->where('req_id', $req->id)->sum('articulo_rm.monto'); }), 2) }}</td>
                            </tr>

                            <tr>
                                <td colspan="4" class="text-right">TOTALES</td>
                                <td class="text-right">
                                    {{ number_format($articulos->sum('monto_cotizado'), 2) }}
                                </td>
                                <td></td>
                                <td class="text-right">
                                    {{ number_format($articulos->sum('sub_total'), 2) }}
                                </td>
                                <td class="text-right">
                                    <b>{{ number_format($articulos->sum('monto_total'), 2) }}</b>
                                </td>

                            </tr>
                        </table>

                        {!! Form::hidden('req_id', $req->id) !!}
                        {!! Form::submit('Aplicar Asignación de RM - Alta', array('class' => 'btn btn-primary btn-sm', 'type' => 'submit')) !!}
                        {!! Form::close() !!}
                        <br>
                        @if($req->estatus == 'Cotizada' && $rms_asignados == true)
                            {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                            <input type="hidden" name="accion" value="Autorizar">
                            <button type="submit" class="btn btn-success btn-sm">Autorizar</button>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
