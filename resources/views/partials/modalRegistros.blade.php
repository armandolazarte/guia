<div class="modal fade" id="modalRegistros" tabindex="-1" role="dialog" aria-labelledby="modalRegistros">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Registro Histórico</h4>
            </div>
            <div class="modal-body">
                @if(isset($registros))
                <table class="table table-compact table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Usuario</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Fecha - Hora</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($registros as $registro)
                        <tr>
                            <td>{{ $registro->user->nombre }}</td>
                            <td>{{ $registro->estatus }}</td>
                            <td class="text-center">{{ $registro->fecha_hora->format('d/m/Y') }}</td>
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
