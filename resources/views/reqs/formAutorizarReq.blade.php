@extends('layouts.theme')

@section('content')

    @include('reqs.partialInfoReq', array('req' => $req))

    @if(count($articulos) > 0)

        <div class="row">
            <div class="col-sm-12">
                {!! Form::open(array('action' => 'AutorizarReqController@asignarRms', 'method' => 'patch', 'class' => 'form-horizontal')) !!}

                {!! Form::select('rm_id', $arr_rms, null, array('class' => 'form-control')) !!}
                <br>

                <table class="table table-bordered table-hover">
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
                    </tr>
                    </thead>
                    @foreach($articulos as $articulo)

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
                        </tr>
                    @endforeach
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
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm', 'type' => 'submit')) !!}
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@stop
