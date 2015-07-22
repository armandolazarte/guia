<div class="modal fade" id="formAsignarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="formAsignarUsuarioModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar derechos de cuenta a usuario</h4>
            </div>
            <div class="modal-body">

                {!! Form::open(array('action' => 'AsignarUsuariosController@store'), array('class' => 'form-horizontal')) !!}
                <div class="form-group">
                    <div class="col-md-4 control-label">Unidad Responsable</div>
                    <div class="col-md-6">
                        {!! Form::select('asignado_user_id', $usuarios, null, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::submit('Aceptar', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::hidden('user_id', $user->id) !!}
                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
