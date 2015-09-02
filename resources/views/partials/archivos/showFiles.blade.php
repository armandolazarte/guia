@if(count($archivos) > 0 || count($archivos_relacionados) > 0)
    <table class="table table-condensed">
        @foreach($archivos as $archivo)
            <tr>
                <td><a href="{{ action('ArchivosController@descargar', $archivo->id) }}">{{ $archivo->name }}</a></td>
            </tr>
        @endforeach

        {{-- Archivos Relacionados con el Egreso --}}
        @if(count($archivos_relacionados) > 0)
            @foreach($archivos_relacionados as $documento_id => $documentos)
                {{-- @todo Mostrar Información del documento a partir del cual se carga --}}
                @foreach($documentos as $archivo)
                    <tr>
                        <td><a href="{{ action('ArchivosController@descargar', $archivo->id) }}">{{ $archivo->name }}</a></td>
                    </tr>
                @endforeach
            @endforeach
        @endif
    </table>
@else
    <div class="alert alert-warning" role="alert">
        <p class="text-center"><b>No hay archivos cargados</b></p>
    </div>
@endif
