@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if( count($reqs) > 0 )
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Requisición</th>
                    <th>Fecha</th>
                    <th>Proyecto</th>
                    <th>Fondo</th>
                    <th>Unidad Responsable</th>
                    <th>Etiqueta</th>
                    <th>Estatus</th>
                    <th>Monto</th>
                    <th>Orden de Compra</th>
                    <th>Fecha OC</th>
                    <th>Estatus OC</th>
                    <th>Responsable Adq.</th>
                </tr>
                </thead>
                @foreach($reqs as $req)
                    <tr>
                        <td><a href="{{ action('RequisicionController@show', array($req->id)) }}">{{ $req->req }}</a></td>
                        <td>{{ $req->fecha_req }}</td>
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
                        <td></td>

                        {{-- Si Oc --}}
                        @if(count($req->ocs) > 0)
                            <td class="text-center">
                                @foreach($req->ocs as $oc)
                                    <a href="{{ action('OcsController@show', $oc->id) }}">{{ $oc->oc }}</a> <br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach($req->ocs as $oc)
                                    {{ $oc->fecha_oc }} <br>
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
