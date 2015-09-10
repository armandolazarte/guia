@if(count($archivos) > 0 || count($archivos_relacionados) > 0)
    <table class="table table-condensed">
        @foreach($archivos as $archivo)
            <tr>
                <td><a href="{{ action('ArchivosController@descargar', $archivo->id) }}">{{ $archivo->name }}</a></td>
                <td>
                    @if($borrar_archivo)
                        <button type="button" class="btn btn-danger btn-sm borrar-archivo" data-toggle="modal" data-target="#modalBorrarArchivo" value="{{ $archivo->id }}">Borrar Archivo</button>
                    @else
                        <button class="btn btn-danger btn-sm" disabled="disabled">Borrar Archivo</button>
                    @endif
                </td>
            </tr>
        @endforeach

        {{-- Archivos Relacionados con el Egreso --}}
        @if(count($archivos_relacionados) > 0)
            @foreach($archivos_relacionados as $documento_id => $documentos)
                {{-- @todo Mostrar Información del documento a partir del cual se carga --}}
                @foreach($documentos as $archivo)
                    <tr>
                        <td><a href="{{ action('ArchivosController@descargar', $archivo->id) }}">{{ $archivo->name }}</a></td>
                        <td>
                            @if($borrar_archivo)
                                <button type="button" class="btn btn-danger btn-sm borrar-archivo" data-toggle="modal" data-target="#modalBorrarArchivo" value="{{ $archivo->id }}">Borrar Archivo</button>
                            @else
                                <button class="btn btn-danger btn-sm" disabled="disabled">Borrar Archivo</button>
                            @endif
                        </td>
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
