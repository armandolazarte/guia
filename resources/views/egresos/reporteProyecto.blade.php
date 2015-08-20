@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('#', 'class' => 'form-horizontal')) !!}
            <div class="form-group">
                {!! Form::label('proyecto_id', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::select('proyecto_id', ['0' => 'Seleccione un proyecto'] + $proyectos, null, array('id' => 'proyecto_id', 'class' => 'form-control')) !!}
                </div>
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
    <script>
        $('#proyecto_id').on('change', function(e) {

            var proyecto_id = e.target.value;
            var cheque_poliza;

            $.get('/api/egresos-proyecto?proyecto_id=' + proyecto_id, function(data){
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
        });
    </script>
@stop
