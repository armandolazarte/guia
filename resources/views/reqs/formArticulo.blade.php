@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('reqs.partialInfoReq', array('req' => $req))
    </div>
</div>

<div class="row">
    @if(isset($articulo))
        {!! Form::model($articulo, array('action' => array('ArticulosController@update', $articulo->id), 'method' => 'patch')) !!}
    @else
        {!! Form::open(array('action' => 'ArticulosController@store')) !!}
    @endif

    @include('partials.formErrors')

    <div class="form-group col-xs-6">
            <label class="sr-only" for="articulo">Artículo</label>
        {!! Form::textarea('articulo', isset($articulo->articulo) ? $articulo->articulo : '', array('cols' => '70', 'rows' => '5', 'class' => 'form-contro', 'placeholder' => 'Descripción del artículo')) !!}
    </div>

    <div class="form-group col-xs-3">
        <label class="sr-only" for="cantidad">Cantidad</label>
        {!! Form::text('cantidad', isset($articulo->cantidad) ? $articulo->cantidad : '', array('class' => 'form-contro', 'placeholder' => 'Cantidad', 'size' => '10')) !!}
    </div>

    <div class="form-group col-xs-2">
        <label class="sr-only" for="unidad">Unidad</label>
        {!! Form::select('unidad', $unidades) !!}
    </div>

    <div class="col-xs-1">
        {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
    </div>
    {!! Form::hidden('req_id', $req->id) !!}
    {!! Form::close() !!}

    @if(isset($articulo))
        {!! Form::open(array('action' => array('ArticulosController@destroy', $articulo->id), 'method' => 'delete')) !!}
        {!! Form::submit('Borrar Artículo', array('class' => 'btn btn-danger btn-sm')) !!}
        {!! Form::close() !!}
    @endif
</div>
@stop