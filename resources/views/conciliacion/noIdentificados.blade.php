@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped table-condensed table-hover">
                <thead>
                <tr>
                    <td class="text-center">ID</td>
                    <td class="text-center">Fecha</td>
                    <td class="text-center">Monto</td>
                </tr>
                </thead>
                <tbody>
                @foreach($no_identificados as $noid)
                    <tr>
                        <td class="text-center">{{ $noid->id }}</td>
                        <td class="text-center">{{ $noid->fecha->format('d/m/Y') }}</td>
                        <td class="text-right">{{ number_format($noid->monto, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td class="text-right">
                        <b>{{ number_format($no_identificados->sum('monto'), 2) }}</b>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
