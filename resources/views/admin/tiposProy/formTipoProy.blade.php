@if(isset($tipoProyecto))
    {!! Form::model($tipoProyecto, array('action' => array('TiposProyectosController@update', $tipoProyecto->id))) !!}
@else
    {!! Form::open(array('action' => 'TiposProyectosController@store')) !!}
@endif

{!! Form::label('tipo_proyecto', 'Tipo de Proyecto') !!}
{!! Form::text('tipo_proyecto') !!}

{!! Form::submit('Aceptar') !!}

{!! Form::close() !!}