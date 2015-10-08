@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">


            {!! Form::open(array('action' => 'NoIdentificadoController@index', 'class' => 'form-horizontal')) !!}
            <div class="form-group">
                {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('cuenta_bancaria_id', $cuentas_bancarias, $cuenta_bancaria_id, array('class'=>'form-control', 'onchange' => 'this.form.submit()')) !!}
                </div>
            </div>
            {!! Form::close() !!}

            <a href="{{ action('NoIdentificadoController@create') }}" class="btn btn-sm btn-primary">Nuevo Depósito No Identificado</a>

            @if( count($no_identificados) > 0 )
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="active">
                        <th class="text-center">Cuenta Bancaria</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Monto</th>
                        <th class="text-center">No. Depósito</th>
                        <th class="text-center">Identificado</th>
                        <th class="text-center">Fecha Identificado</th>
                    </tr>
                    </thead>
                    @foreach($no_identificados as $no_identificado)
                        <tr class="{{ $no_identificado->identificado == 1 ? 'active' : 'warning' }}">
                            <td class="text-center">{{ $no_identificado->cuentaBancaria->cuenta_bancaria }}</td>
                            <td class="text-center">
                                <a href="{{ action('NoIdentificadoController@show', array($no_identificado->id)) }}">{{ $no_identificado->id }}</a>
                            </td>
                            <td class="text-center">{{ $no_identificado->fecha->year == '-0001' ? '' : $no_identificado->fecha->format('d/m/Y') }}</td>
                            <td class="text-right">{{ number_format($no_identificado->monto, 2) }}</td>
                            <td class="text-left">{{ $no_identificado->no_deposito }}</td>
                            <td>{{ $no_identificado->identificado }}</td>
                            <td class="text-center">{{ $no_identificado->fecha_identificado->year == '-0001' ? '---' : $no_identificado->fecha_identificado->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-info">
                    No hay depósitos no identificados por listar
                </div>
            @endif
        </div>
    </div>
@stop
