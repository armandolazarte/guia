@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-12">

            {!! Form::open(['url' => 'http://finanzas.cucei.udg.mx/presu/imprime_ch_temp.php']) !!}
            {{--{!! Form::open(['url' => 'http://legacy.sigi.dev/presu/imprime_ch_temp.php']) !!}--}}

            {!! Form::text('fecha', $fecha_texto, ['readonly']) !!}
            <br>
            {!! Form::text('benef', $egreso->benef->benef, ['readonly']) !!}
            <br>
            {!! Form::text('monto', $egreso->monto, ['readonly']) !!}
            <br>
            {!! Form::text('concepto', $egreso->concepto, ['readonly']) !!}
            <br>
            {!! Form::text('monto_letra', $monto_letra, ['readonly']) !!}
            <br>

            @foreach($egreso->rms as $rm)
                {!! Form::text('rm[]', $rm->rm, ['readonly']) !!}
                {!! Form::text('cog[]', $rm->cog->cog, ['readonly']) !!}
                {!! Form::text('monto_rm[]', $rm->pivot->monto, ['readonly']) !!}
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
