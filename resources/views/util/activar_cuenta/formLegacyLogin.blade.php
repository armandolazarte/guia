@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Activar cuenta de usuario</div>
                <div class="panel-body">

                    @include('partials.formErrors')

                    {!! Form::open(array('action' => 'Util\ActivarCuentaController@legacyLoginCheck', 'class' => 'form-horizontal')) !!}

                    <div class="form-group">
                        {!! Form::label('legacy_username', 'Usuario:', ['class' => 'col-sm-1 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::text('legacy_username', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('legacy_psw', 'Contraseña', ['class' => 'col-sm-1 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::password('legacy_psw', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    {!! Form::submit('Aceptar', ['class' => 'col-sm-offset-1 btn btn-success']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
