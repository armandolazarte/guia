{{-- Recibir modo de tabla: Condensada || Extendida --}}

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

            <table class="table table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Presupuestado</th>
                    <th>Ejercido</th>
                    <th><span data-toggle="tooltip" data-placement="top" title="Vales No Comprobados (sin asignación de RM)">GxC*</span></th>
                    {{--<th>Reembolsado</th>--}}
                    <th>Reintegro DF</th>
                    <th>Reservado</th>
                    <th>Saldo</th>
                </tr>
                </thead>
                <tbody id="ejercicio-proyecto">

                </tbody>
            </table>

            <table class="table table-bordered table-condensed table-hover">
                <thead>
                <tr>
                    <th>Objetivo</th>
                    <th>RM</th>
                    <th>Cta. de Gasto</th>
                    <th>Presupuestado</th>
                    {{--@if($modo_tabla == 'extendida')--}}
                    {{--<th>Depositado</th>--}}{{-- Oculto para URG --}}
                    {{--@endif--}}
                    <th><span data-toggle="tooltip" data-placement="top" title="Compensaciones Internas y Externas">Compensado*</span></th>
                    {{--@if($modo_tabla == 'condensada')--}}
                    <th><span data-toggle="tooltip" data-placement="top" title="Cheques - Cancelaciones + Cargos + Vales (c/RM)">Ejercido*</span></th>{{-- @todo Retenciones --}}
                    {{--@elseif($modo_tabla == 'extendida')--}}
                    {{--<th>Ejercido</th>--}}
                    <th>Reintegro DF</th>{{-- Cheques + Devoluciones directas --}}
                    {{--@endif--}}
                    <th><span data-toggle="tooltip" data-placement="top" title="Requisiciones y Solicitudes Autorizadas">Reservado*</span></th>{{-- Sol. + Req. --}}
                    <th>Saldo</th>
                    {{--@if($modo_tabla == 'extendida')--}}
                    {{--<th>Saldo por Depositar</th>--}}
                    {{--@endif--}}
                </tr>
                </thead>
                <tbody id="ejercicio-rm">

                </tbody>

            </table>
        </div>
    </div>
@stop


@section('js')
    @parent
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <script src="{{ asset('javascript/accounting.min.js') }}"></script>

    <script>
        $('#proyecto_id').on('change', function(e) {

            var proyecto_id = e.target.value;

            $.get('/presupuesto/get-ejercicio-proyecto?proyecto_id=' + proyecto_id, function(ejercicio){
                $('#ejercicio-rm').empty();
                $.each(ejercicio.desgloseRMs.rms, function(index, ejercicioObj) {
                    $('#ejercicio-rm').append('<tr><td>'+ ejercicioObj.objetivo +'</td> <td class="text-center">'+ ejercicioObj.rm +'</td>' +
                            '<td class="text-center"><span data-toggle="tooltip" title="'+ ejercicioObj.d_cog +'">'+ ejercicioObj.cog +'</span></td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.presupuestado, 2) +'</td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.compensado, 2) +'</td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.ejercido, 2) +'</td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.reintegros_df, 2) +'</td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.reservado, 2) +'</td>' +
                            '<td class="text-right">'+ accounting.formatNumber(ejercicioObj.saldo, 2) +'</td>' +
                            '</tr>');

                });
                $('#ejercicio-rm').append('<tr><td></td><td></td><td></td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_presu, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_compensa, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_ejercido, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_reintegros_df, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_reservado, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.desgloseRMs.total.t_saldo, 2) +'</td>' +
                        '</tr>');

                $('#ejercicio-proyecto').empty();
                $('#ejercicio-proyecto').append('<tr>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.presupuestado, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.ejercido, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.valesNoComprobados, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.reintegro_df, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.reservado, 2) +'</td>' +
                        '<td class="text-right">'+ accounting.formatNumber(ejercicio.ejercicioGlobal.saldo, 2) +'</td>' +
                        '</tr>');
            });
        });
    </script>
@stop
