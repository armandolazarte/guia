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
                            @if($accion->modulos()->get()->contains($modulo->id))
                                <li><a href="{{ action($accion->ruta, $accion->modulos()->whereModuloId($modulo->id)->first()->pivot->scope) }}">{{ $accion->nombre }}</a></li>
                            @else
                                <li><a href="{{ action($accion->ruta) }}">{{ $accion->nombre }}</a></li>
                            @endif
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
                            @if($accion->modulos()->get()->contains($modulo->id))
                                <li><a href="{{ action($accion->ruta, $accion->modulos()->whereModuloId($modulo->id)->first()->pivot->scope) }}">{{ $accion->nombre }}</a></li>
                            @else
                                <li><a href="{{ action($accion->ruta) }}">{{ $accion->nombre }}</a></li>
                            @endif
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
                            @if($accion->modulos()->get()->contains($modulo->id))
                                <li><a href="{{ action($accion->ruta, $accion->modulos()->whereModuloId($modulo->id)->first()->pivot->scope) }}">{{ $accion->nombre }}</a></li>
                            @else
                                <li><a href="{{ action($accion->ruta) }}">{{ $accion->nombre }}</a></li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </li>
    @endif
@endforeach
        </ul>
