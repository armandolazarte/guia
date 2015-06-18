<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Presupuesto</div>
            <div class="panel-body">
                <div class="btn-group" role="group">
                    @if($req->estatus == 'Cotizada')
                        <a class="btn btn-primary" role="button" href="{{ action('AutorizarReqController@formAutorizar', $req->id) }}">Asignar RMs y Autorizar</a>
                    @endif
                    <a class="btn btn-warning" role="button" href="#">Regresar</a>
                </div>
                @if($req->estatus == 'Autorizada')
                    {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Desautorizar">
                    <button type="submit" class="btn btn-danger">Desautorizar</button>
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>
</div>
