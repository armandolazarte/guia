@extends('layouts.theme')

@section('content')

<div class="row">
    <div class="col-md-12">
        {!! Form::model($condiciones, array('action' => array('OcsCondicionesController@update', $condiciones->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}

        @include('partials.formErrors')

        <div class="form-group">
            {!! Form::label('forma_pago', 'Forma de Pago', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                    {!! Form::select('forma_pago',[''=>'','Contado'=>'Contado','Parcialidades'=>'Parcialidades'], null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('fecha_entrega', 'Fecha de Entrega', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('fecha_entrega', null, array('class'=>'form-control', 'maxlength' => '20', 'maxwidth' => '20')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('pago', 'Pago', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('pago', null, array('class'=>'form-control', 'maxlength' => '20', 'maxwidth' => '20')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('no_parcialidades', 'No. de Parcialidades', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('no_parcialidades', null, array('class'=>'form-control', 'maxlength' => '3', 'maxwidth' => '3')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('porcentaje_anticipo', 'Porcentaje de Anticipo', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                <div class="input-group">
                    {!! Form::text('porcentaje_anticipo', null, array('class'=>'form-control', 'maxlength' => '3', 'maxwidth' => '3')) !!}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('fianzas', '', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::select('fianzas', [''=>'','Anticipo'=>'Anticipo','Cumplimiento'=>'Cumplimiento'], null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('obs', 'Observaciones', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::textarea('obs', null, array('class'=>'form-control', 'cols' => '60', 'rows' => '2')) !!}
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop