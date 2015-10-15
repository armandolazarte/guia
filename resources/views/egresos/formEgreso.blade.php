@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if(isset($egreso))
                {!! Form::model($egreso, array('action' => array('EgresosController@update', $egreso->id), 'method' => 'patch', 'class' => 'form-horizontal')) !!}
            @else
                {!! Form::open(array('action' => 'EgresosController@store', 'class' => 'form-horizontal')) !!}
            @endif

            @include('partials.formErrors')

                <div class="form-group">
                    {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        {!! Form::select('cuenta_bancaria_id', $cuentas_bancarias, null, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('fecha', 'Fecha', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        {!! Form::text('fecha', $fecha, ['class'=>'form-control', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('cheque', 'No. de Cheque', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        {!! Form::text('cheque', $cheque, array('class'=>'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('benef_id', 'Beneficiario', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        {!! Form::select('benef_id', $benefs, null, array('class' => 'form-control')) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('concepto', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}
                    <div class="col-sm-10">
                        @if(isset($egreso))
                            {!! Form::textarea('concepto', $egreso->concepto, array('class'=>'form-control', 'rows' => '3')) !!}
                        @else
                            {!! Form::textarea('concepto', null, ['class'=>'form-control', 'rows' => '3', 'required']) !!}
                        @endif
                    </div>
                </div>

                @if(!isset($egreso))
                    <div class="form-group">
                        {!! Form::label('cuenta_id', 'Cuenta', array('class' => 'col-sm-2 control-label')) !!}
                        <div class="col-sm-10">
                            {!! Form::select('cuenta_id', ['0' => 'Seleccionar Cuenta'] + $cuentas, null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group" id="div-seleccion-proyecto">
                    <label for="proyecto_id" class="col-sm-2 control-label">Proyecto</label>
                    <div class="col-sm-10">
                        <select id="seleccion-proyecto" name="proyecto_id" class="form-control">
                            <option value="0">---</option>
                        </select>
                    </div>
                </div>

                <div id="recursos-materiales">
                <div class="form-group div-seleccion-rm"></div>
                </div>

                <div class="col-sm-offset-2 col-sm-10">
                    <a href="#" class="btn btn-sm btn-primary btn-add-more-rm">Agregar Recurso Material</a>
                </div>

                @if(!isset($egreso))
                    <div class="form-group">
                        {!! Form::label('monto', 'Monto Total', array('class' => 'col-sm-2 control-label')) !!}
                        <div class="col-sm-3">
                            {!! Form::text('monto', null, ['class'=>'form-control', 'id' => 'monto-total', 'required']) !!}
                        </div>
                        <input type="button" value="Calcular Total" onclick="calcular_total()"/>
                    </div>
                @endif

                <div class="col-sm-offset-2 col-sm-10">
                    {!! Form::submit('Guardar Cheque', array('class' => 'btn btn-success btn-sm')) !!}
                </div>

            {!! Form::close() !!}

            {{--<button id="proyectoId">Asignar RM</button>--}}
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        $(function() {
            $('#cuenta_id').on('change', function(e) {
                var cuenta_id = e.target.value;
                if (cuenta_id == 1 || cuenta_id == 2) {
//                    $('#div-seleccion-proyecto').append('<label for="proyecto_id" class="col-sm-2 control-label">Proyecto</label>' +
//                            '<div class="col-sm-10">' +
//                            '<select id="seleccion-proyecto" name="proyecto_id" class="form-control">' +
//                            '<option value="0">Seleccionar Proyecto</option>' +
//                            '</select>' +
//                            '</div>');

                    $.get('/api/proyectos-dropdown', function(data) {
                        //@todo Borrar Descripción de opción inicial
                        $.each(data, function(index, proyectoObj) {
                            $('#seleccion-proyecto').append('<option value="'+proyectoObj.id+'">'+proyectoObj.proyecto_descripcion+'</option>');
                        });
                    });
                } else {
//                    $('#div-seleccion-proyecto').empty();
                    $('.div-seleccion-rm').empty();
                }
            });
        });
    </script>

    <script>
        $(function() {
            $('#seleccion-proyecto').on('change', function(e) {
                e.preventDefault();
                //console.log(e);

                var proyecto_id = $('#seleccion-proyecto').val();

                $('.div-seleccion-rm').empty();
                $('.div-seleccion-rm').append('<label for="rm[]" class="col-sm-2 control-label">Recurso Material</label>' +
                        '<div class="col-sm-5">' +
                        '<select name="rm[]" class="form-control seleccion-rm"></select>' +
                        '</div>' +
                        '<div class="col-sm-3"><input name="monto_rm[]" class="form-control monto-parcial"></div>');

                //ajax
                $.get('/api/rm-dropdown?proyecto_id=' + proyecto_id, function(data){
                    //console.log(data);
                    $('.seleccion-rm').empty();
                    $.each(data, function(index, rm_origenObj){
                        $('.seleccion-rm').append('<option value="'+rm_origenObj.id+'">'+rm_origenObj.rm+'</option>');
                    });
                });

                $('#monto-total').attr('readonly', true);

            });
        });

        $('.btn-add-more-rm').on('click', function(e) {
            e.preventDefault();

            var clone = $('.div-seleccion-rm').clone();
            clone.attr('class', 'form-group div-seleccion-rm-clone');
            clone.children('input').val(0);

            $('.div-seleccion-rm').parent().append(clone);
        });

    </script>

    <script>
        function calcular_total() {
            monto_total = 0;
            $('.monto-parcial').each(function (index, value) {
                        monto_total = monto_total + eval($(this).val());
                    }
            );
            $('#monto-total').val(monto_total);
        }
    </script>
@stop

