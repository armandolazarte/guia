@extends('layouts.theme')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(isset($prereq))
            {!! Form::model($prereq, array('action' => array('PreReqController@update', $prereq->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
        @else
            {!! Form::open(array('action' => 'PreReqController@store', 'class' => 'form-horizontal')) !!}
        @endif

        @include('partials.formErrors')

        <div class="form-group">
            {!! Form::label('urg_id', 'Solicitar a Unidad Responsable de Gasto', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                <select name="urg_id" class="form-control">
                    @if(isset($req))
                        @foreach($urgs as $urg)
                            <option value="{!! $urg->id !!}" {{ $urg->id == $req->urg_id ? 'selected' : '' }}>{!! $urg->urg !!} - {!! $urg->d_urg !!}</option>
                        @endforeach
                    @else
                        @foreach($urgs as $urg)
                            <option value="{!! $urg->id !!}">{!! $urg->urg !!} - {!! $urg->d_urg !!}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('etiqueta', 'Etiqueta', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('etiqueta', null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('lugar_entrega', 'Lugar de Entrega', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('lugar_entrega', null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('usuario_final', 'Usuario Final', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('usuario_final', null, array('class'=>'form-control')) !!}
            </div>
        </div>

            <div class="form-group">
                {!! Form::label('justifica', 'Justificación', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('justifica', null, array('class'=>'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('grado', 'Gradio de Precisión', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('grado', array('Alto' => 'Alto', 'Medio' => 'Medio', 'Bajo' => 'Bajo'), 'Medio', array('class'=>'form-control')) !!}
                </div>
            </div>

        <div class="form-group">
            {!! Form::label('obs', 'Observaciones', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('obs', null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
        </div>

            {!! Form::hidden('user_id', \Auth::user()->id) !!}
            {!! Form::hidden('fecha', \Carbon\Carbon::now()->toDateString()) !!}
            {!! Form::hidden('tipo_orden', 'Compra') !!}

        {!! Form::close() !!}
    </div>
</div>
@stop