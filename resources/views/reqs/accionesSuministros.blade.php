<div class="row">
    <div class="col-sm-10">
        <div class="panel panel-default">
            <div class="panel-heading">Acciones Unidad de Suministros</div>
            <div class="panel-body">
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
        </div>
    </div>
</div>
