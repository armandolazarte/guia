
    @if( count($acciones) > 0 )
        <table border="1">
            <thead><tr>
                <th>ID</th>
                <th>Ruta</th>
                <th>Nombre</th>
                <th>Icono</th>
                <th>Orden</th>
                <th>Activo</th>
                <th>Modulos</th>
            </tr></thead>
            @foreach($acciones as $accion)
                <tr>
                    <td><a href="{{ action('AccionesController@editar', $accion->id) }}">{{ $accion->id }}</a></td>
                    <td>{{ $accion->ruta }}</td>
                    <td>{{ $accion->nombre }}</td>
                    <td>{{ $accion->icono }}</td>
                    <td>{{ $accion->orden }}</td>
                    <td>{{ $accion->activo }}</td>
                    <td>
                        @foreach($accion->modulos as $modulo)
                            {{ $modulo->nombre }}<br />
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <h3>No hay acciones registradas</h3>
    @endif
