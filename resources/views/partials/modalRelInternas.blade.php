<div class="modal fade " id="modalRelInternas" tabindex="-1" role="dialog" aria-labelledby="modalRelInternas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registro de Relaciones Internas</h4>
            </div>
            <div class="modal-body">
                @if(isset($registros))
                    <table class="table table-compact table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">No. Relación</th>
                            <th class="text-center">Envía</th>
                            <th class="text-center">Fecha de Envío</th>
                            <th class="text-center">Destinatario</th>
                            <th class="text-center">Recibió</th>
                            <th class="text-center">Fecha de Revisión</th>
                            <th class="text-center">Estatus de Relación</th>
                            <th class="text-center">Validacion del Documento</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rel_internas as $rel)
                            <tr>
                                <td class="text-center">{{ $rel->rel_interna_id }}</td>
                                <td>{{ \Guia\User::find($rel->relInterna->envia)->nombre }}</td>
                                <td>{{ $rel->relInterna->fecha_envio_info or '---' }}</td>
                                <td>
                                    @if(isset($rel->relInterna->destino->grupo))
                                        {{ $rel->relInterna->destino->grupo }}
                                    @elseif(isset($rel->relInterna->destino->nombre))
                                        {{$rel->relInterna->destino->nombre }}
                                    @else
                                        No Enviada
                                    @endif
                                </td>
                                <td>
                                    {{ !empty($rel->relInterna->recibe) ? \Guia\User::find($rel->relInterna->recibe)->nombre : '---' }}
                                </td>
                                <td>{{ $rel->relInterna->fecha_revision_info or '---' }}</td>
                                <td>{{ $rel->relInterna->estatus or 'No Enviada' }}</td>
                                <td>{{ $rel->validacion or 'No Recibida' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
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

