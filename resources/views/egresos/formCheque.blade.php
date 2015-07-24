@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['url' => 'http://finanzas.cucei.udg.mx/presu/imprime_ch_temp.php']) !!}
            {{--{!! Form::open(['url' => 'http://legacy.sigi.dev/presu/imprime_ch_temp.php']) !!}--}}

            {!! Form::text('fecha', $fecha_texto, ['readonly', 'class' => 'form-control']) !!}
            <br>
            {!! Form::text('benef', $egreso->benef->benef, ['readonly', 'class' => 'form-control']) !!}
            <br>
            {!! Form::text('monto', round($egreso->monto, 2), ['readonly', 'class' => 'form-control']) !!}
            <br>
            {!! Form::textarea('concepto', $egreso->concepto, ['readonly', 'class' => 'form-control', 'rows' => '3']) !!}
            <br>
            {!! Form::text('monto_letra', $monto_letra, ['readonly', 'class' => 'form-control']) !!}
            <br>

            @foreach($arr_rms as $rm => $value)
                {!! Form::text('rm[]', $rm, ['readonly']) !!}
                {!! Form::text('cog[]', $value['cog'], ['readonly']) !!}
                {!! Form::text('monto_rm[]', round($value['monto'], 2), ['readonly']) !!}
                <br>
            @endforeach
            <br>
            {!! Form::text('proyecto', $egreso->rms[0]->proyecto->proyecto, ['readonly']) !!}
            {!! Form::text('d_proyecto', $egreso->rms[0]->proyecto->d_proyecto, ['readonly']) !!}
            <br>
            {!! Form::text('fondo', $egreso->rms[0]->fondo->fondo, ['readonly']) !!}
            <br>
            {!! Form::text('urg', $egreso->rms[0]->proyecto->urg->urg, ['readonly']) !!}

            <br>
            {!! Form::text('presu', $presu, ['readonly']) !!}
            <br>
            {!! Form::text('cfin', $cfin, ['readonly']) !!}
            <br>
            {!! Form::text('elabora', $elabora) !!}


            {!! Form::submit('Generar Formato de Cheque') !!}


            {!! Form::close() !!}

        </div>
    </div>
@stop
