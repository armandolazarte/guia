@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('prereqs.partialInfoPreReq', array('prereq' => $prereq))
    </div>
</div>

    @if(isset($articulo))
        {!! Form::model($articulo, array('action' => array('PreReqArticulosController@update', $articulo->id), 'method' => 'patch', 'role' => 'form', 'class' => 'form-inline')) !!}
    @else
        {!! Form::open(array('action' => 'PreReqArticulosController@store', 'role' => 'form', 'class' => 'form-inline')) !!}
    @endif

    @include('partials.formErrors')

    <div class="form-group">
        <label class="sr-only" for="articulo">Artículo</label>
        {!! Form::textarea('articulo', isset($articulo->articulo) ? $articulo->articulo : '', array('cols' => '70', 'rows' => '3', 'class' => 'form-contro', 'placeholder' => 'Descripción del artículo')) !!}
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
        {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
    </div>
    {!! Form::hidden('prereq_id', $prereq->id) !!}
    {!! Form::close() !!}

    @if(isset($articulo))
        {!! Form::open(array('action' => array('PreReqArticulosController@destroy', $articulo->id), 'method' => 'delete')) !!}
        {!! Form::submit('Borrar Artículo', array('class' => 'btn btn-danger btn-sm')) !!}
        {!! Form::close() !!}
    @endif
@stop