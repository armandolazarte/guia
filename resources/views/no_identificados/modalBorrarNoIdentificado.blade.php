<div class="modal fade" id="modalBorrarNoIdentificado" tabindex="-1" role="dialog" aria-labelledby="modalBorrarNoIdentificado">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación para Borrar Depósito No Identificado</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    Se eliminará el depósito no identificado
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-1">
                            {!! Form::open(array('action' => ['NoIdentificadoController@destroy', $no_identificado->id], 'method' => 'delete')) !!}
                            {!! Form::submit('Borrar Depósito No Identificado', array('class' => 'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>

                        <div class="col-sm-2 col-sm-offset-9">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>