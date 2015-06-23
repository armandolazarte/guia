@if(count($archivos) > 0)
    <table class="table table-condensed">
        @foreach($archivos as $archivo)
            <tr>
                <td><a href="{{ action('ArchivosController@descargar', $presupuesto.'/'.$archivo->id) }}">{{ $archivo->name }}</a></td>
            </tr>
        @endforeach
    </table>
@else
    No hay archivos cargados
@endif
