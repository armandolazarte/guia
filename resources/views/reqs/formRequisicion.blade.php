@extends('layouts.theme')

@section('content')

@include('partials.filtroPresupuesto')

<div class="row">
    <div class="col-md-12">
        @if(isset($req))
            {!! Form::model($req, array('action' => array('RequisicionController@update', $req->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
        @else
            {!! Form::open(array('action' => 'RequisicionController@store', 'class' => 'form-horizontal')) !!}
        @endif

        @include('partials.formErrors')

        <div class="form-group">
            {!! Form::label('proyecto_id', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::select('proyecto_id', $proyectos, null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('urg_id', 'Unidad Responsable de Aplicación', array('class' => 'col-sm-2 control-label')) !!}
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
            {!! Form::label('obs', 'Observaciones', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                {!! Form::text('obs', null, array('class'=>'form-control')) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('vobo', 'Visto Bueno (Opcional)', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                <select name="vobo">
                    <option value="0">Sin Vo. Bo.</option>
                    @if(isset($req))
                        @foreach($arr_vobo as $vobo)
                            <option value="{!! $vobo->id !!}"{{ $vobo->id == $req->vobo ? ' selected' : '' }}>{!! $vobo->nombre !!} - {!! $vobo->cargo !!}</option>
                        @endforeach
                    @else
                        @foreach($arr_vobo as $vobo)
                            <option value="{!! $vobo->id !!}">{!! $vobo->nombre !!} - {!! $vobo->cargo !!}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}
        </div>

        {!! Form::close() !!}
    </div>
</div>
@stop