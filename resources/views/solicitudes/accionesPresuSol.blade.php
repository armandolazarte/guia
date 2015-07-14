<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Presupuesto</div>
            <div class="panel-body">
                @if($solicitud->estatus == 'Recibida' || $solicitud->estatus == 'Enviada')
                    
                    <div class="btn-group btn-group-sm" role="group">
                    <a class="btn btn-primary" href="{{ action('SolicitudRecursosController@create', array($solicitud->id)) }}">Agregar Recursos</a>
                    <a class="btn btn-primary" href="{{ action('SolicitudController@edit', array($solicitud->id)) }}">Editar Información</a>
                    </div>

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
