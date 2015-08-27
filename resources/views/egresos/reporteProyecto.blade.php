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

            <table class="table table-hover table-bordered table-compact">
                <tr>
                    <th>Cuenta Bancaria</th>
                    <th>Poliza/Cheque</th>
                    <th>Fecha</th>
                    <th>Beneficiario</th>
                    <th>Cuenta Clasificadora</th>
                    <th>Concepto</th>
                    <th>Monto</th>
                    <th>Rec. Mat.</th>
                    <th>Cuenta Gasto</th>
                    <th>Monto (RM)</th>
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

                    var td_rm = '';
                    var td_rm_span = '';
                    var row_span = egresoObj.rms.length;
                    $.each(egresoObj.rms, function(i, rmObj){
                        //console.log(rmObj);
                        if(i == 0) {
                            td_rm += '<td>'+egresoObj.rms[i].rm+'</td> <td>'+rmObj.cog.cog+'</td> <td>'+rmObj.pivot.monto+'</td>';
                        } else {
                            td_rm_span += '<tr><td>'+egresoObj.rms[i].rm+'</td> <td>'+rmObj.cog.cog+'</td> <td>'+rmObj.pivot.monto+'</td></tr>';
                        }
                    });

                    $('#egresos').append('<tr>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.cuenta_bancaria.cuenta_bancaria+'</td>' +
                            '<td rowspan="'+row_span+'">'+cheque_poliza+'</td>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.fecha_info+'</td>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.benef.benef+'</td>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.cuenta.cuenta+'</td>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.concepto+'</td>' +
                            '<td rowspan="'+row_span+'" class="text-right">'+egresoObj.monto+'</td>' +
                            td_rm +
                            '<td rowspan="'+row_span+'">'+egresoObj.estatus+'</td>' +
                            '<td rowspan="'+row_span+'">'+egresoObj.user.nombre+'</td>' +
                    '</tr>');
                    $('#egresos').append(td_rm_span);
                });
            });
        });
    </script>
@stop
