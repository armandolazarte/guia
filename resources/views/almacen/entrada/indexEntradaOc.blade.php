@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(count($ocs) > 0)
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Orden de Compra</th>
                        <th>Fecha OC</th>
                        <th>Proveedor</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    @foreach($ocs as $oc)
                        <tr>
                            <td>{{ $oc->oc }}</td>
                            <td>{{ $oc->fecha_oc }}</td>
                            <td>{{ $oc->benef->benef }}</td>
                            <td>{{ $oc->estatus }}</td>
                            <td><a href="{{ action('EntradaOcController@create', array($oc->oc)) }}">Crear Entrada</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info">
                    No hay Ordenes de Compra Generadas
                </div>
            @endif

        </div>
    </div>
@stop