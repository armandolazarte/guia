<div class="modal fade" id="formBenefModal" tabindex="-1" role="dialog" aria-labelledby="formBenefModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registrar Nuevo Beneficiario</h4>
            </div>

            {!! Form::open(['action' => 'BenefController@store', 'class' => 'form-horizontal']) !!}

            <div class="modal-body">

                <div class="form-group">
                    {!! Form::label('benef', 'Beneficiario o Razón Social', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('benef', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('tipo', 'Tipo de Beneficiario', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::select('tipo', ['Proveedor' => 'Proveedor', 'U de G' => 'Empleado U de G', 'Estudiante' => 'Estudiante', 'Otro' => 'Otro'], null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('tel', 'Teléfono (Opcional)', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('tel', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('correo', 'Correo Electrónico (Opcional)', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('correo', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                {!! Form::submit('Aceptar', ['class' => 'btn btn-success']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

            {!! Form::close() !!}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
