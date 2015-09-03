@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if( count($reqs) > 0 )
            <table class="table table-bordered table-condensed table-hover">
                <thead>
                <tr class="active">
                    <th class="text-center">Requisición</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Proyecto</th>
                    <th class="text-center">Fondo</th>
                    <th class="text-center">Unidad Responsable</th>
                    <th class="text-center">Etiqueta</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Monto Aut.</th>
                    <th class="text-center">Orden de Compra</th>
                    <th class="text-center">Fecha OC</th>
                    <th class="text-center">Estatus OC</th>
                    <th class="text-center">Responsable Adq.</th>
                </tr>
                </thead>
                @foreach($reqs as $req)
                    @if($req->estatus == 'Cotizando')
                        <tr class="active">
                    @elseif($req->estatus == 'Cotizada')
                        <tr class="info">
                    @elseif($req->estatus == 'Autorizada')
                        <tr class="success">
                    @elseif($req->estatus == '')
                        <tr class="warning">
                    @else
                        <tr>
                    @endif
                        <td class="text-center"><a href="{{ action('RequisicionController@show', array($req->id)) }}">{{ $req->req }}</a></td>
                        <td>{{ $req->fecha_info }}</td>
                        <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="{{ $req->proyecto->d_proyecto }}">
                            {{ $req->proyecto->proyecto }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="{{ $req->proyecto->fondos()->pluck('d_fondo') }}">
                                {{ $req->proyecto->fondos()->pluck('fondo') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span data-toggle="tooltip" data-placement="top" title="{{ $req->proyecto->urg->d_urg }}">
                                {{ $req->proyecto->urg->urg }}
                            </span>
                        </td>
                        <td>{{ $req->etiqueta }}</td>
                        <td>{{ $req->estatus }}</td>
                        {{-- Si cotizada --}}
                        @if($req->estatus == 'Autorizada')
                            <td class="text-right">
                                {{ number_format($req->articulos->sum(function ($articulo){ return $articulo->rms()->sum('articulo_rm.monto'); }), 2) }}
                            </td>
                        @else
                            <td></td>
                        @endif
                        {{-- Si Oc --}}
                        @if(count($req->ocs) > 0)
                            <td class="text-center">
                                @foreach($req->ocs as $oc)
                                    <a href="{{ action('OcsController@show', $oc->id) }}">{{ $oc->oc }}</a> <br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach($req->ocs as $oc)
                                    {{ $oc->fecha_oc_info }} <br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach($req->ocs as $oc)
                                    {{ $oc->estatus }} <br>
                                @endforeach
                            </td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif

                        @if(isset($req->user->nombre))
                            <td>{{ $req->user->nombre }}</td>
                        @else
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </table>
        @else
            <div class="alert alert-info">
                No hay requisiciones por listar
            </div>
        @endif
    </div>
</div>
@stop

@section('js')
    @parent
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@stop
