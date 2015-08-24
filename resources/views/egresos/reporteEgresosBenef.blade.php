@extends('layouts.theme')

@section('css')
    @parent
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('#', 'class' => 'form-horizontal', 'method' => 'POST')) !!}
                <div class="form-group">
                    <div class="col-sm-8">
                        {!! Form::text('benef', $value = null, array('placeholder' => 'Buscar beneficiario', 'id' => 'buscar-benef', 'class' => 'form-control')) !!}
                    </div>
                    {!! Form::submit('Consultar', ['class' => 'btn btn-primary col-sm-2', 'id' => 'consultar-benef']) !!}
                </div>
            {!! Form::close() !!}

            <table class="table table-hover table-bordered">
                <tr>
                    <th>Cuenta Bancaria</th>
                    <th>Poliza/Cheque</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Cuenta Clasificadora</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Estatus</th>
                    <th>Respnosable</th>
                </tr>
                <tbody id="egresos">

                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('input:text').bind({

            });

            $('#buscar-benef').autocomplete({
                minLength: 3,
                focus: true,
                source: '{{ url('api/benef-search') }}'
            });
        });
    </script>
@stop
