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

    <script>
        $('#consultar-benef').click(function(e) {
            e.preventDefault();

            var benef = $('#buscar-benef').val();
            var cheque_poliza;

            $.get('/api/benef-id?benef=' + benef, function(benef_id_data) {
                /**
                 * @todo Validar que encuentre el benef_id
                 */
                var benef_id = benef_id_data.benef_id;

                $.get('/api/egresos-benef?benef_id=' + benef_id, function(data){
                    $('#egresos').empty();
                    $.each(data, function(index, egresoObj) {

                        if (egresoObj.poliza == 0) {
                            cheque_poliza = egresoObj.cheque;
                        } else {
                            cheque_poliza = egresoObj.poliza;
                        }

                        $('#egresos').append('<tr>' +
                                '<td>'+egresoObj.cuenta_bancaria.cuenta_bancaria+'</td>' +
                                '<td>'+cheque_poliza+'</td>' +
                                '<td>'+egresoObj.fecha_info+'</td>' +
                                '<td>'+egresoObj.benef.benef+'</td>' +
                                '<td>'+egresoObj.cuenta.cuenta+'</td>' +
                                '<td>'+egresoObj.concepto+'</td>' +
                                '<td class="text-right">'+egresoObj.monto+'</td>' +
                                '<td>'+egresoObj.estatus+'</td>' +
                                '<td>'+egresoObj.user.nombre+'</td>' +
                                '</tr>');
                    });
                });
            }, 'json');
        });
    </script>
@stop
