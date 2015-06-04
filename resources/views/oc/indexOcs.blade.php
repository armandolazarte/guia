@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ action('RequisicionController@show', $req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            @if(count($ocs) > 0)
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Orden de Compra</th>
                        <th>Fecha OC</th>
                        <th>Proveedor</th>
                        <th>Estatus</th>
                        <th>PDF</th>
                    </tr>
                    </thead>
                    @foreach($ocs as $oc)
                        <tr>
                            <td>{{ $oc->oc }}</td>
                            <td>{{ $oc->fecha_oc }}</td>
                            <td>{{ $oc->benef->benef }}</td>
                            <td>{{ $oc->estatus }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ action('OcsCondicionesController@edit', $oc->condiciones->id) }}" role="button">Condiciones</a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ action('OcsController@ordenCompraPdf', $oc->id) }}" role="button" target="_blank">Imprimir</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info">
                    No hay Ordenes de Compra Generadas
                </div>
            @endif
                {!! Form::open(array('action' => array('OcsController@store',$req_id))) !!}
                <div class="col-sm-10">
                    {!! Form::submit('Generar OC', array('class' => 'btn btn-primary btn-sm')) !!}
                </div>
                {!! Form::close() !!}
        </div>
    </div>
@stop