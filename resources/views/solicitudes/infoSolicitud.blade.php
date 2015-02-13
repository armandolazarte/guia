@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <table>
                <tr>
                    <td>Solicitud No.</td>
                    <td>{{ $sol->id }}</td>
                </tr>
                <tr>
                    <td>Tipo de Solicitud</td>
                    <td>{{ $sol->tipo_solicitud }}</td>
                </tr>
                <tr>
                    <td>Proyecto</td>
                    <td>{{ $sol->proyecto->proyecto }} {{ $sol->proyecto->d_proyecto }}</td>
                </tr>
                <tr>
                    <td>URG</td>
                    <td>{{ $sol->urg->urg }} {{ $sol->urg->d_urg }}</td>
                </tr>
                <tr>
                    <td>Beneficiario</td>
                    <td>{{ $sol->benef->benef }}</td>
                </tr>
                <tr>
                    <td>No. Oficio</td>
                    <td>{{ $sol->no_documento }}</td>
                </tr>
                <tr>
                    <td>Concepto</td>
                    <td>{{ $sol->concepto }}</td>
                </tr>
                <tr>
                    <td>Observaciones</td>
                    <td>{{ $sol->obs }}</td>
                </tr>
                <tr>
                    <td>Viáticos</td>
                    <td>{{ !empty($sol->viaticos) ? 'Pago de Viáticos' : '' }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
