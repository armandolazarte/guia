@extends('layouts.theme')

@section('content')

    @if(isset($retencion))
        {!! Form::open(array('action' => array('RetencionController@update', $retencion_id), 'class' => 'form-horizontal', 'method' => 'patch')) !!}
    @else
        {!! Form::open(array('action' => 'RetencionController@store', 'class' => 'form-horizontal')) !!}
    @endif

    @include('partials.formErrors')

    <div class="form-group">
        <label class="col-sm-2 control-label" for="tipo_retencion">Tipo de Retención</label>
        <div class="col-sm-10">
            {!! Form::select('tipo_retencion', ['Honorarios' => 'Honorarios'], null, ['class' => 'form-control']) !!}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="rm_id">Recurso Material</label>
        <div class="col-sm-10">
            <select class="form-control" name="rm_id">
                @foreach($rms as $rm)
                    <option value="{{ $rm->id }}">{{ $rm->rm }} Cuenta: {{ $rm->cog->cog }} ({{ $rm->cog->d_cog }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="monto">Monto</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto" value="{{ $monto or '' }}">
        </div>
    </div>

    @if(!isset($retencion))
        {!! Form::hidden('doc_id', $doc_id) !!}
        {!! Form::hidden('doc_type', $doc_type) !!}
    @endif

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Aceptar', array('class' => 'btn btn-primary')) !!}
        </div>
    </div>

    {!! Form::close() !!}

    @if(isset($solicitud) && isset($retencion_id))
        {!! Form::open(array('action' => array('RetencionController@destroy', $solicitud->id, $retencion_id), 'method' => 'delete')) !!}
        {!! Form::submit('Borrar Retención', array('class' => 'btn btn-danger')) !!}
        {!! Form::close() !!}
    @endif

@stop
