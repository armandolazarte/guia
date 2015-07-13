<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Suministros</div>
            <div class="panel-body">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#proceso" aria-controls="home" role="tab" data-toggle="tab">Proceso de Compra</a></li>
                        <li role="presentation"><a href="#asignar" aria-controls="profile" role="tab" data-toggle="tab">Asignar</a></li>
                        <li role="presentation"><a href="#regresar" aria-controls="messages" role="tab" data-toggle="tab">Regresar</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        {{-- PROCESO SUMINISTROS --}}
                        <div role="tabpanel" class="tab-pane active" id="proceso">
                            <div class="btn-group" role="group">
                                <a class="btn btn-success" role="button" href="{{ action('InvitacionController@create', $req->id) }}"><span>+</span></a>
                                {{--Si existen invitaciones--}}
                                <a class="btn btn-primary" role="button" href="{{ action('InvitacionController@index', $req->id) }}">Invitaciones</a>
                            </div>

                            {{--Cuadro Comparativo--}}
                            <a href="{{ action('MatrizCuadroController@create', $req->id) }}" class="btn btn-primary">Cuadro Comparativo</a>

                            {{--Si ya tiene OC--}}
                            <a href="{{ action('OcsController@index', $req->id) }}" class="btn btn-primary">Ordenes de Compra</a>

                            {{--Si Autorizada--}}
                            @if($req->estatus == 'Autorizada')
                                {!! Form::open(array('action' => array('OcsController@store',$req->id))) !!}
                                {!! Form::submit('Generar Orden de Compra', array('class' => 'btn btn-success')) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>

                        {{-- ASIGNAR REQUISICION --}}
                        <div role="tabpanel" class="tab-pane" id="asignar">
                            {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form-horizontal')) !!}
                            <div class="form-group">
                                {!! Form::label('user_id', 'Asignar a:', ['class' => 'col-sm-2 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::select('user_id', $usuarios_suministros, null, ['class' => 'form-control']) !!}
                                </div>
                                {!! Form::submit('Asignar Requisición', array('class' => 'col-sm-2 btn btn-success')) !!}
                            </div>
                            {!! Form::hidden('accion', 'Asignar') !!}
                            {!! Form::close() !!}
                        </div>

                        {{-- REGRESAR REQUISICION --}}
                        <div role="tabpanel" class="tab-pane" id="regresar">
                            @if($req->estatus == 'Recibida')
                                {!! Form::open(array('action' => ['RequisicionController@update', $req->id], 'method' => 'patch', 'class' => 'form')) !!}
                                {!! Form::hidden('accion', 'Regresar') !!}
                                {!! Form::submit('Regresar Requisición', array('class' => 'btn btn-warning')) !!}
                                {!! Form::close() !!}
                            @else
                                <div class="alert alert-warning">
                                    No se puede regresar la requisición
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
