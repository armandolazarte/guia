@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if( count($reqs) > 0 )
                {!! Form::open(array('action' => 'RecibirController@recibirReq', 'method' => 'patch')) !!}

                @include('partials.formErrors')

                <table class="table-hover">
                    <thead>
                    <tr>
                        <th>Solicitud</th>
                        <th>Fecha</th>
                        <th>Etiqueta</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    @foreach($reqs as $req)
                    <tr>
                        <td>
                            {!! Form::checkbox('arr_req_id[]', $req->id) !!}
                            <a href="{{ action('RequisicionController@show', array($req->id)) }}">{{ $req->req }}</a>
                        </td>
                        <td>{{ $req->fecha_req }}</td>
                        <td>{{ $req->urg->d_urg }}</td>
                        <td>{{ $req->etiqueta }}</td>
                        <td>{{ $req->estatus }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endforeach
                </table>
                {!! Form::submit('Aceptar',  array('class' => 'btn btn-primary btn-sm')) !!}
                {!! Form::hidden('tipo_doc', 'req') !!}
                {!! Form::hidden('estatus', 'Recibida') !!}
                {!! Form::close() !!}
            @else
                <div class="alert alert-info">
                    No hay requisiciones por recibir
                </div>
            @endif
        </div>
    </div>
@stop
