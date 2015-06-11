<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Presupuesto</div>
            <div class="panel-body">
                @if($solicitud->estatus == 'Recibida')
                    {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Autorizar">
                    <button type="submit" class="btn btn-success" role="button">Autorizar</button>
                    {!! Form::close() !!}
                @endif

                @if($solicitud->estatus == 'Autorizada')
                    {!! Form::open(array('action' => ['SolicitudController@update', $solicitud->id], 'method' => 'patch', 'class' => 'form')) !!}
                    <input type="hidden" name="accion" value="Desautorizar">
                    <button type="submit" class="btn btn-warning" role="button">Desautorizar</button>
                    {!! Form::close() !!}
                @endif

                <a class="btn btn-primary" role="button" href="#">Regresar</a>
            </div>
        </div>
    </div>
</div>
