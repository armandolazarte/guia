@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('reqs.partialInfoReq', array('req' => $req))
    </div>
</div>

<div class="row">
    @if(isset($articulo))
        {!! Form::model($articulo, array('action' => array('ArticulosController@update', $articulo->id), 'method' => 'patch', 'role' => 'form', 'class' => 'form-inline')) !!}
    @else
        {!! Form::open(array('action' => 'ArticulosController@store', 'role' => 'form', 'class' => 'form-inline')) !!}
    @endif

    @include('partials.formErrors')

    <div class="form-group">
            <label class="sr-only" for="articulo">Artículo</label>
        {!! Form::textarea('articulo', isset($articulo->articulo) ? $articulo->articulo : '', array('cols' => '70', 'rows' => '5', 'class' => 'form-control', 'placeholder' => 'Descripción del artículo')) !!}
    </div>

    <div class="form-group">
        <label class="sr-only" for="cantidad">Cantidad</label>
        {!! Form::text('cantidad', isset($articulo->cantidad) ? $articulo->cantidad : '', array('class' => 'form-contro', 'placeholder' => 'Cantidad', 'size' => '10')) !!}
    </div>

    <div class="form-group">
        <label class="sr-only" for="unidad">Unidad</label>
        {!! Form::select('unidad', $unidades) !!}
    </div>

    <div class="form-group">
        <label for="inventariable">Alta Patrimonial</label>
        @if(isset($articulo))
            {!! Form::checkbox('inventariable', 1, $articulo->inventariable) !!}
        @else
            {!! Form::checkbox('inventariable', 1) !!}
        @endif
    </div>

    <div class="form-group">
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