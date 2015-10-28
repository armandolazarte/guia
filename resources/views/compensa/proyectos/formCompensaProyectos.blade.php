@extends('layouts.theme')

@section('content')

    {{--    @include('partials.filtroPresupuesto')--}}

    <div class="row">
        <div class="col-sm-12">

            {!! Form::open(array('action' => 'CompensaProyectosController@store', 'class' => 'form-horizontal')) !!}

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

                        <div class="form-group">
                            {!! Form::label('proyecto_id_origen', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-9">
                                {!! Form::select('proyecto_id_origen', ['0' => 'Seleccione un proyecto'] + $proyectos, null, array('id' => 'proyecto_id_origen', 'class' => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="grupo-rm-origen">
                            <div class="alert-info">
                                <h5><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></h5>
                            </div>
                            <div class="form-group rmorigen-select-container">
                                {!! Form::label('rm_origen', 'Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="rm_origen[]", class="form-control seleccion-rm-origen">
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

                        <div class="form-group">
                            {!! Form::label('proyecto_id_destino', 'Proyecto', array('class' => 'col-sm-2 control-label')) !!}
                            <div class="col-sm-9">
                                {!! Form::select('proyecto_id_destino', ['0' => 'Seleccione un proyecto'] + $proyectos, null, array('id' => 'proyecto_id_destino', 'class' => 'form-control')) !!}
                            </div>
                        </div>

                        {{-- RM Destino Existente --}}
                        <div class="grupo-rm-destino">
                            <div class="alert-info">
                                <h5><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>Recurso Material Existente</h5>
                            </div>
                            <div class="form-group">
                                {!! Form::label('rm_destino', 'Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="rm_destino[]", id="rm_destino" class="form-control seleccion-rm-destino">
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

                        {{-- Nuevo RM Destino --}}
                        <div class="grupo-rm-nuevo">
                            <div class="alert-success">
                                <h5><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>Nuevo Recurso Material</h5>
                            </div>

                            <div class="form-group">
                                {!! Form::label('objetivo_destino', 'Objetivo', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="objetivo_destino", id="objetivo_destino" class="form-control seleccion-objetivo-destino">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            {{-- Captura Nuevo RM --}}
                            <div class="form-group">
                                {!! Form::label('rm_nuevo', 'Nuevo Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <input name="rm_nuevo[]" class="form-control">
                                </div>
                            </div>
                            {{-- Selección COG --}}
                            <div class="form-group">
                                {!! Form::label('cog_nuevo', 'Cuenta de Objeto de Gasto', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="cog_nuevo[]", class="form-control">
                                        @foreach($cogs as $cog)
                                            <option value="{{ $cog->id }}">{{ $cog->cog }} {{ $cog->d_cog }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- Captura monto del RM nuevo --}}
                            <div class="form-group">
                                {!! Form::label('monto_nuevo_rm', 'Monto', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <input name="monto_nuevo_rm[]" class="form-control">
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
        $('#proyecto_id_origen').on('change', function(e) {
            var proyecto_id = e.target.value;
            $.get('/dropdown-api/rms/' + proyecto_id, function(data){
                $('.seleccion-rm-origen').empty();
                $.each(data, function(index, rm_origenObj){
                    $('.seleccion-rm-origen').append('<option value="'+rm_origenObj.id+'">'+rm_origenObj.rm+'</option>');
                });
            });
        });

        $('#proyecto_id_destino').on('change', function(e) {
            var proyecto_id = e.target.value;
            $.get('/dropdown-api/rms/' + proyecto_id, function(data){
                $('.seleccion-rm-destino').empty();
                $.each(data, function(index, rm_origenObj){
                    $('.seleccion-rm-destino').append('<option value="'+rm_origenObj.id+'">'+rm_origenObj.rm+'</option>');
                });
            });

            $.get('/dropdown-api/objetivos/' + proyecto_id, function(data) {
                $('.seleccion-objetivo-destino').empty();
                $.each(data, function(index, objetivo){
                    $('.seleccion-objetivo-destino').append('<option value="'+objetivo.id+'">'+objetivo.objetivo_desc+'</option>');
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