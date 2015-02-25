{!! Form::open() !!}

<select name="sel_presupuesto" onchange="this.form.submit()">
    @for($i = $presupuesto_inicial; $i <= $presupuesto_actual; $i++)
            <option value="{{$i}}"{{ $sel_presupuesto == $i ? ' selected' : '' }}>{{ $i }}</option>
    @endfor
</select>

{!! Form::close() !!}
