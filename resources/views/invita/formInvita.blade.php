@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @include('benefs.formBenefModal')

            <a href="{{ action('RequisicionController@show', $req_id) }}" class="btn btn-primary btn-sm">Regresar a Requisición</a>

            @include('partials.formErrors')

            @if(isset($cotizacion))
                {!! Form::model($cotizacion, array('action' => array('InvitacionController@update', $cotizacion->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'InvitacionController@store')) !!}
            @endif

            <div class="form-group">
                {!! Form::label('benef_id', 'Seleccionar Proveedor', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-8">
                    {!! Form::select('benef_id', $benefs, null, array('class' => 'form-control')) !!}
                </div>

                <div class="col-sm-2">
                    {!! Form::submit('Aceptar', array('class' => 'btn btn-success btn-sm')) !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10">
                    <button type="button" class="btn btn-success col-sm-2" data-toggle="modal" data-target="#formBenefModal">Registrar Nuevo</button>
                </div>
            </div>

            {!! Form::hidden('req_id', $req_id) !!}
            {!! Form::close() !!}

            @if(isset($cotizacion))
                {!! Form::open(array('action' => ['InvitacionController@destroy', $cotizacion->id], 'method' => 'delete')) !!}
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! Form::submit('Borrar Invitación', array('class' => 'btn btn-danger btn-sm')) !!}
                    </div>
                {!! Form::close() !!}
            @endif

        </div>
    </div>
@stop
