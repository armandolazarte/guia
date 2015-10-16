@extends('layouts.theme')

@section('content')

{{--    @include('partials.filtroPresupuesto')--}}

    <div class="row">
        <div class="col-sm-12">

            {!! Form::open(array('action' => 'CompensaExternaController@store', 'class' => 'form-horizontal')) !!}

            <div class="form-group">
                {!! Form::label('urg_externa_id', 'URG Externa', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::select('urg_externa_id', ['0' => 'Seleccione la Dependencia Externa'] + $urg_externas, null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('concepto', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-6">
                    {!! Form::text('concepto', null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::select('tipo_compensa_externa', ['' => 'Seleccionar Tipo', 'Abono' => 'Abono', 'Cargo' => 'Cargo'], null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('proyecto_id', 'Proyecto de Aplicación', array('class' => 'col-sm-2 control-label')) !!}
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


            {{-- RM Interno --}}
            <div class="col-sm-offset-2 col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">Recurso Material</h4>
                    </div>

                    <div class="panel-body">
                        {{-- RM Interno Existente --}}
                        <div class="grupo-rm-aplicacion">
                            <div class="alert-info">
                                <h5><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>Recurso Material Existente</h5>
                            </div>
                            <div class="form-group">
                                {!! Form::label('rm_aplicacion', 'Recurso Material', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <select name="rm_aplicacion[]", id="rm_aplicacion" class="form-control seleccion-rm">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('monto_aplicacion', 'Monto', array('class' => 'col-sm-4 control-label')) !!}
                                <div class="col-sm-8">
                                    <input name="monto_aplicacion[]" class="form-control">
                                    {{--{!! Form::text('monto_destino[]', null, ['class' => 'form-control']) !!}--}}
                                </div>
                            </div>
                        </div>

                        {{-- Nuevo RM --}}
                        <div class="grupo-rm-nuevo">
                            <div class="alert-success">
                                <h5><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>Nuevo Recurso Material</h5>
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
                        <a href="#" class="btn btn-sm btn-primary btn-add-more-rmd">Agregar Selección de Recurso Material</a>
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
                $('#rm_aplicacion').empty();
                $.each(data, function(index, rm_aplicacionObj){
                    $('#rm_aplicacion').append('<option value="'+rm_aplicacionObj.id+'">'+rm_aplicacionObj.rm+'</option>');
                });

            });
        });

        /**
         * Clona div de clase grupo-rm-aplicacion
         *
         * Al hacer click, clona .grupo-rm-aplicacion
         * y lo coloca dentro del panel-body
         *
         */
        $('.btn-add-more-rmd').on('click', function(e) {
            e.preventDefault();

            var clone = $('.grupo-rm-aplicacion').clone();
            clone.attr('class', 'grupo-rm-aplicacion-clone');

            $(this).parent().siblings(".panel-body").append(clone);
        });


    </script>
@stop