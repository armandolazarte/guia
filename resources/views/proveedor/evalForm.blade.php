@extends('layouts.theme')

@section('content')
    <div class="page-header">
        <h1>Evaluación de Proveedor</h1>
    </div>
    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-success">
                <div class="panel-heading">Evaluación a {Nombre del Proveedor}</div>
                <div class="panel-body">

                    {!! Form::open(['class' => 'form-horizontal']) !!}

                    <div class="form-group">
                        {!! Form::label('criterio_1', 'Crédito', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('criterio_1', null, array('class'=>'form-control', 'placeholder'=>'0 - 25')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('criterio_2', 'Precio', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('criterio_2', null, array('class'=>'form-control', 'placeholder'=>'0 - 30')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('criterio_3', 'Entrega oportuna', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('criterio_3', null, array('class'=>'form-control', 'placeholder'=>'0 - 20')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('criterio_4', 'Garantía', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('criterio_4', null, array('class'=>'form-control', 'placeholder'=>'0 - 15')) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('criterio_5', 'Atención', array('class' => 'col-sm-3 control-label')) !!}
                        <div class="col-sm-2">
                            {!! Form::text('criterio_5', null, array('class'=>'form-control', 'placeholder'=>'0 - 10')) !!}
                        </div>
                    </div>

                    <div class="col-sm-offset-3 col-sm-2">
                        {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>
@stop