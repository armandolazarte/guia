@if(count($archivos) > 0)
    <table class="table table-condensed">
        @foreach($archivos as $archivo)
            <tr>
                <td><a href="#{{-- action('ArchivosController@descargar', $presupuesto.'/'.$archivo->id) --}}">{{ $archivo->name }}</a></td>
            </tr>
        @endforeach
    </table>
@else
    <div class="alert alert-warning" role="alert">
        <p class="text-center"><b>No hay archivos cargados</b></p>
    </div>
@endif
