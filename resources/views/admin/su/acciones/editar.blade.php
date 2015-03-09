<p>Editar información para la ruta: <b>{{ $accion->ruta }}</b></p>

{!! Form::model($accion, array('action' => array('AccionesController@actualizar', $accion->id))) !!}

{!! Form::label('nombre', 'Nombre') !!}
{!! Form::text('nombre') !!}

{!! Form::label('icono', 'Icono') !!}
{!! Form::text('icono') !!}

{!! Form::label('orden', 'Orden') !!}
{!! Form::text('orden') !!}

{!! Form::label('activo', 'Activo') !!}
{!! Form::checkbox('activo', '1', false) !!}

@foreach($modulos as $modulo)
    {!! Form::label('accion_modulo[]', $modulo->nombre) !!}
    {!! Form::checkbox('accion_modulo[]', $modulo->id, $accion->modulos->contains($modulo->id)) !!}
@endforeach

{!! Form::submit('Aceptar') !!}

{!! Form::close() !!}