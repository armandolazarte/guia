@extends('layouts.theme')

@section('content')
    @if(isset($modulo))
        {!! Form::model($modulo, array('action' => array('ModuloController@update', $modulo->id))) !!}
    @else
        {!! Form::open(array('action' => 'ModuloController@store')) !!}
    @endif

    {!! Form::label('ruta', 'Ruta:') !!}
    {!! Form::text('ruta') !!}

    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre') !!}

    {!! Form::label('icnono', 'Icono:') !!}
    {!! Form::text('icono') !!}

    {!! Form::label('orden', 'Orden:') !!}
    {!! Form::text('orden') !!}

    {!! Form::label('activo', 'Activo:') !!}
    {!! Form::checkbox('activo') !!}

    <div class="panel panel-default">
        <div class="panel-heading">Selección de Roles</div>
        <div class="panel-body">
            @foreach($roles as $role)
                {!! Form::label('modulo_role[]', $role->role_name, array('class' => 'checkbox-inline')) !!}
                @if(isset($modulo))
                    {!! Form::checkbox('modulo_role[]', $role->id, $modulo->roles->contains($role->id)) !!}
                @else
                    {!! Form::checkbox('modulo_role[]', $role->id, false) !!}
                @endif
            @endforeach
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Selección de Acciones</div>
        <div class="panel-body">
            <table class="table table-condensed">
                <thead><tr>
                    <th>Ruta</th>
                    <th>Scope</th>
                    <th>Nombre</th>
                </tr></thead>
                @foreach($acciones as $accion)
                    <tr>
                        <td>
                            @if(isset($modulo))
                                {!! Form::checkbox('accion_modulo[]', $accion->id, $modulo->acciones->contains($accion->id)) !!}
                            @else
                                {!! Form::checkbox('accion_modulo[]', $accion->id, false) !!}
                            @endif
                                {!! Form::label('accion_modulo[]', $accion->ruta) !!}
                        </td>
                        <td>
                            @if($accion->modulos()->get()->contains($modulo->id))
                                {!! Form::text('scope_'.$accion->id, $accion->modulos()->whereModuloId($modulo->id)->first()->pivot->scope) !!}
                            @else
                                {!! Form::text('scope_'.$accion->id) !!}
                            @endif
                        </td>
                        <td>{{ $accion->nombre }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {!! Form::submit('Aceptar') !!}

    {!! Form::close() !!}
@stop