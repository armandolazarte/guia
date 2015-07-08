@if(count($usuarios_asignados) > 0)
    <ul>
    @foreach($usuarios_asignados as $usuario_asignado)
            <li>
                <a href="{{ action('UsuarioAsignadoController@loginAsignado', [$usuario_asignado->id]) }}">
                    {{ $usuario_asignado->nombre }}
                </a>
            </li>
    @endforeach
    </ul>
@endif