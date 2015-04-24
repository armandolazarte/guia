@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.formErrors')

            @if(isset($cotizacion))
                {!! Form::model($cotizacion, array('action' => array('InvitacionController@update', $cotizacion->id), 'method' => 'patch')) !!}
            @else
                {!! Form::open(array('action' => 'InvitacionController@store')) !!}
            @endif

            <div class="form-group">
                {!! Form::label('benef_id', 'Proveedor', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('benef_id', $benefs, null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('fecha_invitacion', 'Fecha de la Invitación', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('fecha_invitacion', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            {!! Form::hidden('req_id', $req_id) !!}
            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
