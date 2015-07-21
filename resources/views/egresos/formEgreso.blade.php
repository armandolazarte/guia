@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if(isset($egreso))
                {!! Form::model($egreso, array('action' => array('EgresosController@update', $egreso->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'EgresosController@store', 'class' => 'form-horizontal')) !!}
            @endif

            @include('partials.formErrors')

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('fecha', 'Fecha', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::text('fecha', null, array('class'=>'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('concepto_id', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::select('concepto', $conceptos, null, array('class' => 'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('cuenta_id', 'Cuenta Bancaria', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::select('cuenta_id', $cuentas, null, array('class' => 'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('benef_id', 'Beneficiario', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::select('benef_id', $benefs, null, array('class' => 'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('poliza', 'No. de Cheque', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::text('poliza', null, array('class'=>'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    {!! Form::label('concepto', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('concepto', $egreso->concepto, array('class'=>'form-control', 'rows' => '5')) !!}
                    </div>
                </div>

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('monto', 'Monto', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::text('monto', null, array('class'=>'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('cmt', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}--}}
                    {{--<div class="col-sm-10">--}}
                        {{--{!! Form::textarea('cmt', null, array('cols'=>'80', 'rows'=>'2', 'class'=>'form-control')) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop

