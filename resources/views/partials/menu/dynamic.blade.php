{{-- Menú dinámico del sistema --}}
@foreach($modulos as $modulo)
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="{{ $modulo->ruta }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ $modulo->nombre }}<span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
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
        </ul>
@endforeach
