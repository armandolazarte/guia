<!-- search box -->
@if($search_box)
<div id="searchbox" class="input-group searchbox">
    {!! Form::open(['action' => 'SearchController@buscarDocumento', 'role' => 'form', 'class' => 'form-inline']) !!}
    <div class="form-group">
        {!! Form::text('no_documento', null, ['class' => 'form-control', 'placeholder' => 'Buscar Documento', 'type' => 'search']) !!}
    </div>
    <div class="form-group">
        {!! Form::select('tipo_documento', ['Solicitud' => 'Solicitud'], null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
        </span>
    </div>
    {!! Form::close() !!}
</div>
@endif
<!-- end search box -->
