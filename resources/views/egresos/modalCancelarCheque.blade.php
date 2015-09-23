<div class="modal fade" id="modalCancelarCheque" tabindex="-1" role="dialog" aria-labelledby="modalCancelarCheque">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de Cancelación de Cheque</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    Al cancelar el cheque {{ $egreso->cheque }} se cancelará el pago de los siguientes documentos:

                    @if(count($egreso->solicitudes) > 0)
                        <ul>
                            @foreach($egreso->solicitudes as $solicitud)
                                <li>Solicitud <strong>{{ $solicitud->id }}</strong></li>
                            @endforeach
                        </ul>
                    @endif
                    @if(count($egreso->ocs) > 0)
                        <ul>
                            @foreach($egreso->ocs as $oc)
                                <li>Orden de Compra <strong>{{ $oc->oc }}</strong></li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::open(array('action' => ['EgresosController@cancelar', $egreso->id], 'method' => 'delete', 'class' => 'form-horizontal')) !!}
                            <div class="form-group">
                                <div class="col-sm-9">
                                    {!! Form::label('motivo', 'Motivo', ['class' => 'sr-only']) !!}
                                    {!! Form::text('motivo', null, ['class' => 'form-control', 'placeholder' => 'Motivo de Cancelación']) !!}
                                </div>
                                {!! Form::submit('Cancelar Cheque', array('class' => 'col-sm-3 btn btn-danger')) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>