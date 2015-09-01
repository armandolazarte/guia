@include('reqs.modalRegresarReq')
<div class="row">
    <div class="col-sm-11">
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

                            <div class="row">
                                {{--Invitaciones--}}
                                <div class="col-sm-2">
                                    @if(count($req->cotizaciones) == 0)
                                        <a href="{{ action('InvitacionController@create', $req->id) }}" class="btn btn-success btn-sm">Agregar Invitación</a>
                                    @else
                                        <a href="{{ action('InvitacionController@index', $req->id) }}" class="btn btn-primary btn-sm"><span class="badge">{{ count($req->cotizaciones) }}</span> Invitaciones</a>
                                    @endif
                                </div>

                                {{--Cuadro Comparativo--}}
                                <div class="col-sm-2">
                                    <a href="{{ action('MatrizCuadroController@create', $req->id) }}" class="btn btn-primary btn-sm{{ count($req->cotizaciones) > 0 ? '' : ' disabled' }}"><span class="badge">{{ count($req->cuadros) }}</span> Cuadro Comparativo</a>
                                </div>

                                {{--Si ya tiene OC--}}
                                <div class="col-sm-2">
                                    <a href="{{ action('OcsController@index', $req->id) }}" class="btn btn-primary btn-sm{{ count($req->cuadros) > 0 ? '' : ' disabled' }}"><span class="badge">{{ count($req->ocs) }}</span> Ordenes de Compra</a>
                                </div>

                                {{--Generar Orden de Compra--}}
                                <div class="col-sm-2">
                                    @if($req->estatus == 'Autorizada' || $req->proyecto->tipo_proyecto_id == 3)
                                        {!! Form::open(array('action' => array('OcsController@store',$req->id))) !!}
                                        {!! Form::submit('Generar Orden de Compra', array('class' => 'btn btn-success btn-sm')) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <button class="btn btn-success btn-sm" disabled="disabled">Generar Orden de Compra</button>
                                    @endif
                                </div>
                            </div>
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
                            @if($req->estatus != 'Autorizada' && $req->estatus != 'Pagada')
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalRegresarReq">Regresar Requisición</button>
                            @else
                                <div class="alert alert-warning">
                                    La requisición está <strong>{{ $req->estatus }}</strong> por lo que no se puede regresar
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
