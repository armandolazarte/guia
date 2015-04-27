@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(count($cotizacion) > 0)
                <table>
                    <thead>
                    <tr>
                        <th>Beneficiario</th>
                        <th>Fecha de Invitación</th>
                    </tr>
                    </thead>
                    @foreach($cotizaciones as $cotiza)
                        <tr>
                            <td>{{ $cotiza->benef->d_benef }}</td>
                            <td>{{ $cotiza->fecha_invitacion }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info">
                    No hay invitaciones capturadas
                </div>
            @endif
            <a href="{{ action('InvitacionController@create', $req_id) }}" class="btn btn-success">Agregar Invitación</a>
        </div>
    </div>
@stop
