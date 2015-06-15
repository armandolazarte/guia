<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Presupuesto</div>
            <div class="panel-body">
                <div class="btn-group" role="group">
                    <a class="btn btn-success" role="button" href="{{ action('AutorizarReqController@formAutorizar', $req->id) }}">Autorizar</a>
                    <a class="btn btn-warning" role="button" href="#">Regresar</a>
                    <a class="btn btn-danger" role="button" href="#">Desautorizar</a>
                </div>
            </div>
        </div>
    </div>
</div>
