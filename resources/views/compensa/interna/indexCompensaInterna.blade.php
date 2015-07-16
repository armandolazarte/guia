@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-sm-10">
            @if(count($compensaciones) == 0)
                <div class="alert-info">
                    No hay compensaciones registradas
                </div>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Documento AFIN</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                    </tr>
                    @foreach($compensaciones as $compensa)
                        <tr>
                            <td>{{ $compensa->id }}</td>
                            <td>{{ $compensa->documento_afin }}</td>
                            <td>{{ $compensa->fecha }}</td>
                            <td>{{ $compensa->tipo }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@stop
