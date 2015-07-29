<div class="modal fade" id="formRelIntModal" tabindex="-1" role="dialog" aria-labelledby="formRelIntModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Crear Nueva Relación</h4>
            </div>

            <div class="modal-body">

                {!! Form::open(array('action' => 'RelacionInternaController@store'), array('class' => 'form-horizontal')) !!}
                {!! Form::hidden('tipo_documentos', 'Egresos') !!}
                {!! Form::submit('Cheques/Egresos', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}

                {{--{!! Form::open(array('action' => 'RelacionInternaController@store'), array('class' => 'form-horizontal')) !!}--}}
                {{--{!! Form::hidden('tipo_documentos', 'Solicitudes') !!}--}}
                {{--{!! Form::submit('Solicitudes', ['class' => 'btn btn-primary']) !!}--}}
                {{--{!! Form::close() !!}--}}

                {{--{!! Form::open(array('action' => 'RelacionInternaController@store'), array('class' => 'form-horizontal')) !!}--}}
                {{--{!! Form::hidden('tipo_documentos', 'OCs') !!}--}}
                {{--{!! Form::submit('Ordenes de Compra', ['class' => 'btn btn-primary']) !!}--}}
                {{--{!! Form::close() !!}--}}

                {{--{!! Form::open(array('action' => 'RelacionInternaController@store'), array('class' => 'form-horizontal')) !!}--}}
                {{--{!! Form::hidden('tipo_documentos', 'Comprobaciones') !!}--}}
                {{--{!! Form::submit('Comprobaciones', ['class' => 'btn btn-primary']) !!}--}}
                {{--{!! Form::close() !!}--}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->