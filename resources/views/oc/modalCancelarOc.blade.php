<div class="modal fade" id="modalCancelarOc" tabindex="-1" role="dialog" aria-labelledby="modalCancelarOc">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de cancelación de Orden de Compra</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    Cancelar la Orden de Compra <strong>{{ $oc->oc }}</strong>
                    a favor de:<br> <strong>{{ $oc->benef->benef }}</strong>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::open(['action' => ['OcsController@destroy', $oc->id], 'method' => 'delete']) !!}
                    <button type="submit" class="btn btn-danger">Cancelar Orden de Compra</button>
                {!! Form::close() !!}

                <button type="button" class="btn btn-primary" data-dismiss="modal">Regresar</button>
            </div>
        </div>
    </div>
</div>