{{-- Requiere js --}}
<div class="form-inline">
    <div class="form-group">
        {!! Form::label('cuenta_bancaria_id', 'Cuenta Bancaria', ['class' => 'sr-only']) !!}
        {!! Form::select('cuenta_bancaria_id', ['0' => 'Cuenta Bancaria'] + $cuentas_bancarias, null, ['class' => 'form-control input-sm', 'id' => 'SelCuentaBancaria']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('aaaa', 'Año', array('class' => 'sr-only')) !!}
        <select name="aaaa" class="form-control input-sm" id="SelAaaa">
            <option value="0">Año</option>
            @for($i = $presupuesto_inicial; $i <= $presupuesto_actual; $i++)
                <option value="{{$i}}"{{ $sel_presupuesto == $i ? ' selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        {!! Form::label('mes', 'Mes', array('class' => 'sr-only')) !!}
        {!! Form::select('mes', ['0' => 'Mes'] + $meses, null, ['class' => 'form-control input-sm', 'id' => 'SelMes']) !!}
    </div>
</div>
