@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open(array('action' => 'EgresosController@store', 'class' => 'form-horizontal')) !!}

            @include('partials.formErrors')

            <div class="form-group">
                {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('cuenta_bancaria_id', $cuentas_bancarias, null, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('fecha', 'Fecha', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::text('fecha', \Carbon\Carbon::today()->toDateString(), ['class'=>'form-control', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('cheque', 'No. de Cheque', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-5">
                    {!! Form::text('cheque', $cheque, array('class'=>'form-control', 'id' => 'cheque')) !!}
                </div>

                {!! Form::label('transferencia', 'Transferencia Bancaria', array('class' => 'col-sm-3 control-label')) !!}
                <div class="col-sm-2 text-left">
                    {!! Form::checkbox('transferencia', 1, false, ['id' => 'transferencia']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('benef_id', 'Beneficiario', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::select('benef_id', $benefs, $doc->benef_id, array('class' => 'form-control')) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('concepto', 'Concepto', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    {!! Form::textarea('concepto', $concepto, ['class'=>'form-control', 'rows' => '3', 'required']) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="documento" class="col-sm-2 control-label">Documento</label>
                <div class="col-sm-10">
                    @if($doc_type == 'Solicitud')
                        {!! Form::text('documento', 'Solicitud No. '.$doc->id, ['class' => 'form-control', 'disabled']) !!}
                    @elseif($doc_type == 'Oc')
                        {!! Form::text('doccumento', 'Orden de Compra No. '.$doc->oc, ['class' => 'form-control', 'disabled']) !!}
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="proyecto_id" class="col-sm-2 control-label">Proyecto</label>
                <div class="col-sm-10">
                    @if($doc_type == 'Solicitud')
                        {!! Form::text('proyecto', $doc->proyecto->proyecto.' '.$doc->proyecto->d_proyecto, ['class' => 'form-control', 'disabled']) !!}
                    @elseif($doc_type == 'Oc')
                        {!! Form::text('proyecto', $doc->req->proyecto->proyecto.' '.$doc->req->proyecto->d_proyecto, ['class' => 'form-control', 'disabled']) !!}
                    @endif
                </div>
            </div>

            @foreach($arr_rms as $rm_id => $rm_info)
                <div class="form-group">
                    <label for="recurso_material" class="col-sm-2 control-label">Recurso Material</label>
                    <div class="col-sm-5">
                        {!! Form::text('recurso_material', $rm_info['rm'].' / '.$rm_info['cog'], ['class' => 'form-control', 'disabled']) !!}
                        {!! Form::hidden('rm_id[]', $rm_id) !!}
                    </div>
                    <div class="col-sm-3">
                        <input name="monto_rm[]" value="{{ round($rm_info['monto'] * $porcentaje / 100, 2) }}" class="form-control monto-parcial">
                    </div>
                    <div class="col-sm-2">
                        {{ $porcentaje }}% de ${{ number_format($rm_info['monto'], 2) }}
                    </div>
                </div>
            @endforeach

            <div class="form-group">
                {!! Form::label('tipo_pago', 'Tipo de Pago', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-3">
                    {!! Form::select('tipo_pago', $tipo_pago, $tipo_pago_sel, array('class' => 'form-control')) !!}
                </div>

                <div class="col-sm-2 text-right">
                    {!! Form::label('monto', 'Monto Total', array('class' => 'control-label')) !!}
                </div>
                <div class="col-sm-3">
                    {!! Form::text('monto', null, ['class'=>'form-control', 'id' => 'monto-total', 'required']) !!}
                </div>
                <div class="col-sm-2">
                    <input type="button" value="Calcular Total" onclick="calcular_total()"/>
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-5">
                {!! Form::submit('Generar Cheque', array('class' => 'btn btn-success btn-sm')) !!}
            </div>

            {!! Form::hidden('doc_id', $doc_id) !!}
            {!! Form::hidden('doc_type', $doc_type) !!}
            {!! Form::hidden('cuenta_id', $cuenta_id) !!}
            {!! Form::close() !!}

        </div>
    </div>
@stop

@section('js')
    @parent
    <script src="{{ asset('javascript/accounting.min.js') }}"></script>
    <script>
        function calcular_total() {
            var monto_total = Number(0);
            $('.monto-parcial').each(function (index, value) {
                        monto_total = Number(monto_total) + Number( eval($(this).val()) );
                        monto_total = accounting.toFixed(monto_total,2);
                    }
            );
            $('#monto-total').val(monto_total);
        }
    </script>
    <script>
        $(function()
        {
            $('#transferencia').click(inhabilitar_cheque);
        });

        function inhabilitar_cheque() {
            if (this.checked) {
                $('#cheque').attr('disabled', true);
            } else {
                $('#cheque').removeAttr('disabled');
            }
        }
    </script>
@stop

