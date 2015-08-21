@extends('layouts.theme')

@section('content')
<div class="row">
    <div class="col-md-12">

        @include('benefs.formBenefModal')

        @if(isset($sol))
            {!! Form::model($sol, array('action' => array('SolicitudController@update', $sol->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @if($sol->monto != 0)
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Para cambiar el proyecto deben eliminarse los recursos.
                </div>
            @endif
        @else
            {!! Form::open(array('action' => 'SolicitudController@store', 'class' => 'form-horizontal')) !!}
        @endif

        @include('partials.formErrors')

        <div class="form-group">
            {!! Form::label('tipo_solicitud', 'Tipo de Solicitud', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::select('tipo_solicitud', $tipos_solicitud, null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('proyecto_id', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                @if(isset($sol))
                    {!! Form::select('proyecto_id', $proyectos, null, array('class' => 'form-control', $sol->monto == 0 ? '' : 'disabled')) !!}
                    @if($sol->monto != 0)
                        <input type="hidden" name="proyecto_id" value="{{ $sol->proyecto_id }}">
                    @endif
                @else
                    {!! Form::select('proyecto_id', $proyectos, null, array('class' => 'form-control')) !!}
                @endif
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('urg_id', 'Unidad Responsable de Aplicación', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::select('urg_id', $urgs, null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('benef_id', 'Beneficiario del Cheque', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-9">
                {!! Form::select('benef_id', $benefs, null, array('class' => 'form-control')) !!}
            </div>
            <button type="button" class="btn btn-success btn-sm col-sm-1" data-toggle="modal" data-target="#formBenefModal">Registrar Nuevo</button>
        </div>

        <div class="form-group">
            {!! Form::label('no_documento', 'No. Oficio', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('no_documento', null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('concepto', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::textarea('concepto', null, array('cols'=>'80', 'rows'=>'2', 'class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('obs', 'Observaciones', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::textarea('obs', null, array('cols'=>'80', 'rows'=>'2', 'class'=>'form-control', 'placeholder' => '(Opcional)')) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('viaticos', '1', null) !!}
                        {{--<input type="checkbox" name="viaticos" value="1">--}}
                        Pago de Viáticos
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('vobo', 'Visto Bueno (Opcional)', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::select('vobo', $arr_vobo, null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
        </div>

    {!! Form::close() !!}
    </div>
</div>
@stop
