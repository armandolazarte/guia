@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('action' => 'EntradaOcController@store', 'class' => 'form-horizontal')) !!}

            @include('partials.formErrors')

            <div class="form-group">
                {!! Form::label('urg_id', 'Unidad Responsable de Aplicación', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <select name="urg_id" class="form-control">
                        @foreach($urgs as $urg)
                            <option value="{!! $urg->id !!}">{!! $urg->urg !!} - {!! $urg->d_urg !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('cmt', 'Comentarios:', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('cmt', null, array('size' => '50', 'class' => 'form-control')) !!}
                </div>
            </div>

            <table class="table table-bordered">
                <thead><tr>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Unidad</th>
                </tr></thead>
                @foreach ($articulos as $art)
                    <tr>
                        <td>
                            {!! Form::checkbox('arr_articulo_id[]', $art->id, true) !!}
                            {{ $art->articulo }}
                        </td>
                        <td>
                            {!! Form::text('cantidad_'.$art->id, $art->cantidad, array('size' => '20')) !!}
                        </td>
                        <td>{{ $art->costo }}</td>
                        <td>{{ $art->impuesto }}</td>
                        <td>{{ $art->monto }}</td>
                        <td>{{ $art->unidad }}</td>
                    </tr>
                @endforeach
            </table>
            {!! Form::hidden('oc', $oc[0]->oc) !!}
            {!! Form::hidden('fecha_oc', $oc[0]->fecha_oc) !!}
            {!! Form::hidden('benef_id', $oc[0]->benef_id) !!}

            {!! Form::submit('Aceptar') !!}

            {!! Form::close() !!}
        </div>
    </div>
@stop
