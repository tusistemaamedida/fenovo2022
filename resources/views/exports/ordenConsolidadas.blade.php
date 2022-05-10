<table>
    <tr>
        <td>Nro</td>
        <td>Fecha Orden</td>
        <td>Destino</td>
        <td>Items</td>
        <td>Tipo</td>
        <td>Kgrs</td>
        <td>Bultos</td>
        <td>Flete</td>
        <td>Neto</td>
    </tr>
    @foreach($arrMovimientos as $movimiento)
    <tr>
        <td>{{ $movimiento->id }}</td>
        <td>{{ $movimiento->fecha }}</td>
        <td>{{ $movimiento->destino }}</td>
        <td>{{ $movimiento->items }}</td>
        <td>{{ $movimiento->tipo }}</td>
        <td>{{ $movimiento->kgrs }}</td>
        <td>{{ $movimiento->bultos }}</td>
        <td>{{ $movimiento->flete }}</td>
        <td>{{ $movimiento->neto }}</td>
    </tr>
    @endforeach

</table>