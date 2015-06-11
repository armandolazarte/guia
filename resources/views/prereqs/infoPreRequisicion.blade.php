@extends('layouts.theme')

@section('content')

    @include('prereqs.partialInfoPreReq', array('prereq' => $prereq))

    @if(count($articulos) > 0)
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                </tr>
            </thead>
            @foreach($articulos as $articulo)
            <tr>
                <td>
                    @if($prereq->estatus == "")
                        <a href="{{ action('PreReqArticulosController@edit', array($prereq->id, $articulo->id)) }}">{{ $articulo->articulo }}</a>
                    @else
                        {!! $articulo->articulo !!}
                    @endif
                </td>
                <td>{!! $articulo->cantidad !!}</td>
                <td>{!! $articulo->unidad !!}</td>
            </tr>
            @endforeach
        </table>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <div class="btn-group btn-group-sm" role="group">
                @if($prereq->estatus == "")
                    <a class="btn btn-primary" href="{{ action('PreReqArticulosController@create', array($prereq->id)) }}">Agregar Artículo</a>
                    <a class="btn btn-primary" href="{{ action('PreReqController@edit', array($prereq->id)) }}">Editar Información</a>
                @endif
            </div>
        </div>

        <div class="col-sm-6">
            <div class="row">
                @if($prereq->estatus == '' && count($articulos) > 0)
                <div class="col-md-4">
                    {!! Form::open(array('action' => ['PreReqController@update', $prereq->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Enviar">
                    <button class="btn btn-success" type="submit">Enviar a URG</button>
                    {!! Form::close() !!}
                </div>
                @endif

                @if($prereq->estatus == 'Enviada')
                    <div class="col-md-4">
                        {!! Form::open(array('action' => ['PreReqController@update', $prereq->id], 'method' => 'patch', 'class' => 'form')) !!}
                        <input type="hidden" name="accion" value="Recuperar">
                        <button type="submit" class="btn btn-warning">Recuperar</button>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop