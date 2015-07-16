@extends('layouts.theme')

@section('content')

{{--    @include('partials.filtroPresupuesto')--}}

    <div class="row">
        <div class="col-sm-12">

            {!! Form::open(array('action' => 'CompensaInternaController@store', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                {!! Form::label('proyecto_id', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::select('proyecto_id', ['0' => 'Seleccione un proyecto'] + $proyectos, null, array('id' => 'proyecto_id', 'class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('documento_afin', 'Documento AFIN', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-6">
                    {!! Form::text('documento_afin', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Guardar Compensación', ['class' => 'btn btn-success col-sm-3']) !!}

            </div>

            {{-- Origen --}}
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Recurso Material Origen</h4>
                    </div>

                    <div class="panel-body">
                        <div class="grupo-rm-origen">
                            <div class="form-group rmorigen-select-container">
                                {!! Form::label('rm_origen', 'Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="rm_origen[]", class="form-control seleccion-rm">
                                        <option value=""></option>
                                    </select>
                                </div>
                                {{--<a href="#" class="btn btn-sm btn-danger btn-remove-rmo">- RMs (Origen)</a>--}}
                            </div>

                            <div class="form-group">
                                {!! Form::label('monto_origen', 'Monto', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <input name="monto_origen[]" class="form-control">
                                    {{--{!! Form::text('monto_origen[]', null, ['class' => 'form-control']) !!}--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <a href="#" class="btn btn-sm btn-primary btn-add-more-rmo">Agregar Selección RM Origen</a>
                    </div>
                </div>
            </div>

            {{-- Destino --}}
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Recurso Material Destino</h4>
                    </div>

                    <div class="panel-body">
                        <div class="grupo-rm-destino">
                            <div class="form-group">
                                {!! Form::label('rm_destino', 'Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="rm_destino[]", id="rm_destino" class="form-control seleccion-rm">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('monto_destino', 'Monto', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <input name="monto_destino[]" class="form-control">
                                    {{--{!! Form::text('monto_destino[]', null, ['class' => 'form-control']) !!}--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <a href="#" class="btn btn-sm btn-primary btn-add-more-rmd">Agregar Selección RM Destino</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        /**
         * Consulta ajax a api/rm-dropdown para obtener RMs del proyecto
         */
        $('#proyecto_id').on('change', function(e) {
//            console.log(e);
            var proyecto_id = e.target.value;
            //ajax
            $.get('/api/rm-dropdown?proyecto_id=' + proyecto_id, function(data){
//                console.log(data);
                $('.seleccion-rm').empty();
                $.each(data, function(index, rm_origenObj){
                    $('.seleccion-rm').append('<option value="'+rm_origenObj.id+'">'+rm_origenObj.rm+'</option>');
                });

                $('#rm_destino').empty();
                $.each(data, function(index, rm_destinoObj){
                    $('#rm_destino').append('<option value="'+rm_destinoObj.id+'">'+rm_destinoObj.rm+'</option>');
                });

            });
        });

        /**
         * Clona div de clase grupo-rm-origen
         *
         * Al hacer click, clona .grupo-rm-origen
         * y lo coloca dentro del panel-body
         *
         */
        $('.btn-add-more-rmo').on('click', function(e) {
            e.preventDefault();

            var clone = $('.grupo-rm-origen').clone();
            clone.attr('class', 'grupo-rm-destino-clone');

            $(this).parent().siblings(".panel-body").append(clone);
        });

        $('.btn-add-more-rmd').on('click', function(e) {
            e.preventDefault();

            var clone = $('.grupo-rm-destino').clone();
            clone.attr('class', 'grupo-rm-destino-clone');

            $(this).parent().siblings(".panel-body").append(clone);
        });


    </script>
@stop