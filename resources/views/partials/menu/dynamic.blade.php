{{-- Menú dinámico del sistema --}}
@foreach($modulos as $modulo)
    @if($modulo->orden == $modulos->first()->orden)
        <!-- Inicio Menú Principal -->
        <ul>
            <li><a href="/{{ $modulo->ruta }}">{{ $modulo->nombre }}</a></li>
    @elseif($modulo->ruta == '#')
        </ul>
        <ul>
            <li><a href="/{{ $modulo->ruta }}">{{ $modulo->nombre }}</a></li>
    @else
            <li><a href="{{ $modulo->ruta }}">{{ $modulo->nombre }}</a></li>
    @endif
@endforeach
        </ul>
