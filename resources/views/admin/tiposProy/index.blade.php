<a href="{{ action('TiposProyectosController@create') }}">Capturar Nuevo Tipo de Proyecto</a>

@if( count($tiposProyecto) > 0 )
    <table border="1">
        <thead><tr>
            <th>ID</th>
            <th>Tipo de Proyecto</th>
        </tr></thead>
        @foreach($tiposProyecto as $tipo)
            <tr>
                <td><a href="{{ action('TiposProyectosController@edit', $tipo->id) }}">{{ $tipo->id }}</a></td>
                <td>{{ $tipo->tipo_proyecto }}</td>
            </tr>
        @endforeach
    </table>
@else
    <h3>No se han dado de alta tipos de proyecto</h3>
@endif