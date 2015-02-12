<a href="{{ action('ImportarProyectoController@index') }}">Importar Proyecto</a>

@if( count($proyectos) > 0 )
    <table border="1">
        <thead><tr>
            <th>Proyecto</th>
            <th>Nombre del Proyecto</th>
            <th>Monto</th>
            <th>URG</th>
            <th>Tipo de Proyecto</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
        </tr></thead>
        @foreach($proyectos as $proyecto)
            <tr>
                <td>{{ $proyecto->proyecto }}</td>
                <td>{{ $proyecto->d_proyecto }}</td>
                <td>{{ $proyecto->monto }}</td>
                <td>{{ $proyecto->urg->urg }} {{ $proyecto->urg->d_urg }}</td>
                <td>{{-- $tipo->tipo_proyecto --}}</td>
                <td>{{ $proyecto->fecha_inicio }}</td>
                <td>{{ $proyecto->fecha_fin }}</td>
            </tr>
        @endforeach
    </table>
@else
    <h3>No se han agregado proyectos</h3>
@endif
