{{-- Menú dinámico del sistema --}}
@foreach($modulos as $modulo)
    @if($modulo->orden == $modulos->first()->orden)
        <!-- Inicio Menú Principal -->
        <ul>
            <li>
                <a href="/{{ $modulo->ruta }}">{{ $modulo->nombre }}</a>
                <ul>
                    @foreach($modulo->acciones as $accion)
                        @if($accion->activo)
                            <li><a href="/{{ $accion->ruta }}">{{ $accion->nombre }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
    @elseif($modulo->ruta == '#')
        </ul>
        <ul>
            <li>
                <a href="/{{ $modulo->ruta }}">{{ $modulo->nombre }}</a>
                <ul>
                    @foreach($modulo->acciones as $accion)
                        @if($accion->activo)
                            <li><a href="/{{ $accion->ruta }}">{{ $accion->nombre }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
    @else
            <li>
                <a href="{{ $modulo->ruta }}">{{ $modulo->nombre }}</a>
                <ul>
                    @foreach($modulo->acciones as $accion)
                        @if($accion->activo)
                            <li><a href="/{{ $accion->ruta }}">{{ $accion->nombre }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
    @endif
@endforeach
        </ul>
