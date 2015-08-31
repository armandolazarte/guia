<div class="modal fade" id="modalCancelarCuadro" tabindex="-1" role="dialog" aria-labelledby="modalCancelarCuadro">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Confirmación de cancelación de Cuadro Comparativo</h4>
            </div>
            <div class="modal-body">

                <div class="alert alert-info" role="alert">
                    Para modificar información en el cuadro comparativo se suguiere "Reanudarlo"
                    {!! Form::open(array('action' => array('CuadroController@update', $cuadro_id), 'method' => 'patch')) !!}
                    {!! Form::hidden('id', $cuadro_id) !!}
                    {!! Form::hidden('accion', 'Reanudar') !!}
                    {!! Form::submit('Reanudar Cuadro', array('class' => 'btn btn-primary btn-sm')) !!}
                    {!! Form::close() !!}
                </div>

                <div class="alert alert-danger" role="alert">
                    Cancelar Cuadro de Requisición <strong>{{ $req_id }}</strong>
                    @if(count($cotizaciones) > 0)
                        <br>Se cancelarán las Invitaciones y Cotizaciones de los proveedores:
                        <ul>
                            @foreach($cotizaciones as $cotizacion)
                                <li>Proveedor <strong>{{ $cotizacion->benef->benef }}</strong></li>
                            @endforeach
                        </ul>
                    @endif
                    @if(count($ocs) > 0)
                        <br>Se cancelarán las Ordenes de Compra:
                        <ul>
                        @foreach($ocs as $oc)
                            <li>Orden <strong>{{ $oc->oc }} {{ $oc->benef->benef }}</strong></li>
                        @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3">
                            {!! Form::open(array('action' => array('CuadroController@destroy', $cuadro_id), 'method' => 'delete')) !!}
                            {!! Form::submit('Cancelar Cuadro Comparativo', array('class' => 'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="col-sm-3 col-sm-offset-6">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Regresar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
