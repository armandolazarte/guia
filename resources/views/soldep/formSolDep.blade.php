@extends('layouts.theme')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(isset($soldep))
                {!! Form::model($soldep, array('action' => array('SolDepositoController@update', $soldep->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'SolDepositoController@store', 'class' => 'form-horizontal')) !!}
            @endif

            @include('partials.formErrors')

            <div class="form-group">
                {!! Form::label('fondo_id', 'Fondo', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('fondo_id', $fondos, null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('afin_soldep', 'Sol. Dep. AFIN', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('afin_soldep', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-10">
                {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop