@extends('app')

@section('content')
<div class="row">
    <div class="col-md-12">

        @if(isset($sol))
            {!! Form::model($req, array('action' => array('SolicitudController@update', $sol->id))) !!}
        @else
            {!! Form::open(array('action' => 'SolicitudController@store')) !!}
        @endif

        <div class="form-group">
            @foreach($errors->get('tipo_solicitud') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('tipo_solicitud', 'Tipo de Solicitud') !!}
            <select name="tipo_solicitud">
                <option value="Reposicion">Reposicion (Reembolso)</option>
                <option value="Recibo">Recibo (Pago a Proveedor)</option>
                <option value="Vale">Vale (Gasto por Comprobar)</option>
            </select>
        </div>

        <div class="form-group">
            @foreach($errors->get('proyecto_id') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('proyecto_id', 'Proyecto') !!}
            {!! Form::select('proyecto_id', $proyectos) !!}
        </div>

        <div class="form-group">
            @foreach($errors->get('urg_id') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('urg_id', 'Unidad Responsable de Aplicación') !!}
            <select name="urg_id">
                @foreach($urgs as $urg)
                    <option value="{!! $urg->id !!}">{!! $urg->urg !!} - {!! $urg->d_urg !!}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @foreach($errors->get('benef_id') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('benef_id', 'Beneficiario del Cheque') !!}
            <select name="benef_id">
                @foreach($benefs as $benef)
                    <option value="{{ $benef->id }}">{{ $benef->benef }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            @foreach($errors->get('no_documento') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('no_documento', 'No. Oficio') !!}
            {!! Form::text('no_documento', '', array('class'=>'form-control')) !!}
        </div>

        <div class="form-group">
        @foreach($errors->get('concepto') as $message)
            {!! $message !!}
        @endforeach
        {!! Form::label('concepto', 'Concepto') !!}
        {!! Form::textarea('concepto', '', array('cols'=>'80', 'rows'=>'2', 'class'=>'form-control')) !!}
        </div>

        <div class="form-group">
        @foreach($errors->get('obs') as $message)
            {!! $message !!}
        @endforeach
        {!! Form::label('obs', 'Observaciones') !!}
        {!! Form::textarea('obs', '', array('cols'=>'80', 'rows'=>'2', 'class'=>'form-control', 'placeholder' => '(Opcional)')) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="viaticos" value="1">
                Pago de Viáticos
            </label>
        </div>

        <div class="form-group">
            @foreach($errors->get('vobo') as $message)
                {!! $message !!}
            @endforeach
            {!! Form::label('vobo', 'Visto Bueno (Opcional)') !!}
            <select name="vobo">
                <option value="0">Sin Vo. Bo.</option>
                @foreach($arr_vobo as $vobo)
                    <option value="{!! $vobo->id !!}">{!! $vobo->nombre !!} - {!! $vobo->cargo !!}</option>
                @endforeach
            </select>
        </div>

    {!! Form::submit('Aceptar', array('class' => 'btn btn-primary btn-sm')) !!}

    {!! Form::close() !!}
    </div>
</div>
@stop
