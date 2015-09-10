<div class="modal fade" id="modalBorrarArchivo" tabindex="-1" role="dialog" aria-labelledby="modalBorrarArchivo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de Eliminación de Archivo</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    El archivo <b id="nombre-archivo"></b> se borrará permanentemente del sistema.
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::open(array('action' => 'ArchivosController@destroy', 'id' => 'borrar-archivo-form', 'method' => 'delete', 'class' => 'form')) !!}
                            {!! Form::submit('Borrar Archivo', array('class' => 'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="col-sm-3 col-sm-offset-6">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
