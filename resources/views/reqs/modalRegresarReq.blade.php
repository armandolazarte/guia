<div class="modal fade" id="modalRegresarReq" tabindex="-1" role="dialog" aria-labelledby="modalRegresarReq">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación para regresar requisición</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                    @if(count($req->cuadros) == 0 && count($req->cotizaciones) == 0 && count($req->ocs) == 0)
                        La requisición <strong>{{ $req->req }}</strong> será regresada al solicitante.
                    @else
                        Al regresar la requisición se cancelarán los siguientes documentos:

                        @if(count($req->cuadros) > 0)
                            <ul>
                                @foreach($req->cuadros as $cuadro)
                                    <li>Cuadro Comparativo <strong>{{ $cuadro->id }}</strong></li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($req->cotizaciones) > 0)
                            <br>Invitaciones y Cotizaciones:
                            <ul>
                                @foreach($req->cotizaciones as $cotizacion)
                                    <li><strong>{{ $cotizacion->benef->benef }}</strong></li>
                                @endforeach
                            </ul>
                        @endif
                        @if(count($req->ocs) > 0)
                            <br>Ordenes de Compra:
                            <ul>
                                @foreach($req->ocs as $oc)
                                    <li><strong>{{ $oc->oc }} {{ $oc->benef->benef }}</strong></li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                            {!! Form::hidden('accion', 'Regresar') !!}
                            {!! Form::submit('Regresar Requisición', array('class' => 'btn btn-warning')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="col-sm-3 col-sm-offset-6">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Volver</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
