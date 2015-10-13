{{-- Requiere js --}}
<div class="form-inline">
    <div class="form-group">
        {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', ['class' => 'sr-only']) !!}
        {!! Form::select('cuenta_bancaria_id', ['0' => 'Cuenta Bancaria'] + $cuentas_bancarias, null, ['class' => 'form-control input-sm', 'id' => 'SelCuentaBancaria']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('aaaa', 'Año', array('class' => 'sr-only')) !!}
        {!! Form::select('aaaa', ['0' => 'Año'] + $aaaa, null, ['class' => 'form-control input-sm', 'id' => 'SelAaaa']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('mes', 'Mes', array('class' => 'sr-only')) !!}
        {!! Form::select('mes', ['0' => 'Mes'] + $meses, null, ['class' => 'form-control input-sm', 'id' => 'SelMes']) !!}
    </div>
</div>
