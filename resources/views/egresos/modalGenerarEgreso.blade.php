<div class="modal fade" id="modalGenerarEgreso" tabindex="-1" role="dialog" aria-labelledby="modalGenerarEgreso">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Opciones para la generación del cheque</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">

                        <a href="{{ action('GenerarEgresoController@create', ['pago/100']) }}" class="btn btn-info ruta-dinamica">Editar Pago</a>
                        <a href="{{ action('GenerarEgresoController@create', ['reintegro/100']) }}" class="btn btn-info ruta-dinamica">Reintegro a DF</a>
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pago Parcial (%) <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @for($i = 9; $i > 0; $i--)
                                        <li><a href="{{ action('GenerarEgresoController@create', ['pago/'.$i.'0']) }}" class="ruta-dinamica">{{ $i }}0 %</a></li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-3 col-sm-offset-9">
                            <button type="button" class="btn btn-primary cerrar-modal" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>