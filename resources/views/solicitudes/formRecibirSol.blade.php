@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if( count($solicitudes) > 0 )
                {!! Form::open(array('action' => 'RecibirController@recibirSol', 'method' => 'patch')) !!}

                @include('partials.formErrors')

                <table class="table-hover">
                    <thead>
                    <tr>
                        <th>Solicitud</th>
                        <th>Fecha</th>
                        <th>Unidad Responsable</th>
                        <th>Concepto</th>
                        <th>Estatus</th>
                        <th>Monto</th>
                    </tr>
                    </thead>
                    @foreach($solicitudes as $sol)
                        <tr>
                            <td>
                                {!! Form::checkbox('arr_sol_id[]', $sol->id) !!}
                                <a href="{{ action('SolicitudController@show', array($sol->id)) }}">{{ $sol->id }}</a>
                            </td>
                            <td>{{ $sol->fecha }}</td>
                            <td>{{ $sol->urg->d_urg }}</td>
                            <td>{{ $sol->concepto }}</td>
                            <td>{{ $sol->estatus }}</td>
                            <td>{{ $sol->monto }}</td>
                        </tr>
                    @endforeach
                </table>
                {!! Form::submit('Aceptar',  array('class' => 'btn btn-primary btn-sm')) !!}
                {!! Form::hidden('tipo_doc', 'sol') !!}
                {!! Form::hidden('estatus', 'Recibida') !!}
                {!! Form::close() !!}
            @else
                <div class="alert alert-info">
                    No hay solicitudes por recibir
                </div>
            @endif
        </div>
    </div>
@stop
