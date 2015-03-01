<div class="modal fade" id="formCargosModal" tabindex="-1" role="dialog" aria-labelledby="formCargosModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cargos</h4>
            </div>
            {!! Form::open(array('action' => 'CargosController@store', $user->id), array('class' => 'form-horizontal')) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('cargo', 'Cargo', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('cargo', $user->cargo, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('inicio', 'Fecha Inicio', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('inicio', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('fin', 'Fecha Fin', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('fin', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 control-label">Roles</div>
                        <div class="col-md-6">
                            @foreach($urgs as $urg)
                                {!! Form::checkbox('cargo_urg[]', $urg->id, false) !!}
                                {!! Form::label('cargo_urg[]', $urg->urg.' '.$urg->d_urg) !!}
                                <br>
                            @endforeach
                        </div>
                    </div>
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