@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(isset($no_identificado))
                {!! Form::model($no_identificado, array('action' => array('NoIdentificadoController@update', $no_identificado->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'NoIdentificadoController@store', 'class' => 'form-horizontal')) !!}
            @endif

            @include('partials.formErrors')

            <div class="form-group">
                {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('cuenta_bancaria_id', $cuentas_bancarias, null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('fecha', 'Fecha', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('fecha', \Carbon\Carbon::today()->toDateString(), array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('monto', 'Monto', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('monto', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('no_deposito', 'No. Depósito', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('no_deposito', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop