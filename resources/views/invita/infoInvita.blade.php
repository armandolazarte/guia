@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(isset($cotizacion))
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Beneficiario</th>
                        <th>Fecha de Invitación</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>{{ $cotizacion->benef->benef }}</td>
                        <td>{{ $cotizacion->fecha_invitacion }}</td>
                    </tr>
                </table>
            @else
                <div class="alert alert-info">
                    No hay invitaciones capturadas
                </div>
            @endif

            {!! Form::open(array('action' => ['InvitacionController@destroy', $cotizacion->id], 'method' => 'delete')) !!}
            {!! Form::submit('Borrar', array('class' => 'btn btn-danger btn-sm')) !!}
            {!! Form::close() !!}

        </div>
    </div>
@stop