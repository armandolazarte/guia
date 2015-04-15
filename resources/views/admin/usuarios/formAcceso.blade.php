<div class="modal fade" id="formAccesoModal" tabindex="-1" role="dialog" aria-labelledby="formAccesoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Acceso Presupuestal</h4>
            </div>
            {!! Form::open(array('action' => 'AccesosController@store'), array('class' => 'form-horizontal')) !!}
            <div class="modal-body">

                <div class="form-group">
                    <div class="col-md-4 control-label">Unidad Responsable</div>
                    <div class="col-md-6">
                        @foreach($urgs as $urg)
                            {!! Form::checkbox('acceso_urg_id[]', $urg->id, false) !!}
                            {!! Form::label('acceso_urg_id[]', $urg->urg.' '.$urg->d_urg) !!}
                            <br>
                        @endforeach
                    </div>
                </div>
                {!! Form::hidden('acceso_type', 'Guia\Models\Urg') !!}

                {!! Form::hidden('user_id', $user->id) !!}
            </div>
            <div class="modal-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
