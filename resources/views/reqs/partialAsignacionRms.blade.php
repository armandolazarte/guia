<table class="table-bordered">
    <tr class="bg-info">
        <th>Cuenta de Gasto</th>
        <th>Recurso Material</th>
        <th>Monto Autorizado</th>
    </tr>
    @foreach($rms_articulos as $rm)
        <tr id="subtotal-rm-{{ $rm->rm }}" class="bg-info">
            <td class="text-center">{{ $rm->cog->cog }}</td>
            <td class="text-center">{{ $rm->rm }}</td>
            <td class="text-right">{{ number_format($rm->articulos()->sum('articulo_rm.monto'), 2) }}</td>
        </tr>
    @endforeach
    <tr id="total-autorizado" class="bg-success">
        <td colspan="2" class="text-right">Total Autorizado</td>
        <td class="text-right">{{ number_format($rms_articulos->sum(function ($rm){ return $rm->articulos()->sum('articulo_rm.monto'); }), 2) }}</td>
    </tr>
</table>