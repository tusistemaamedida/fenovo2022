<table>
    <tr>
        <td colspan="15">{{ $data }}</td>
    </tr>
    @foreach($arrMovimientos as $movimiento)
    <tr>
        <td>{{ $movimiento->id }}</td>
        <td>{{ $movimiento->fecha }}</td>
        <td>{{ $movimiento->destino_id }}</td>
        <td>{{ $movimiento->destino }}</td>
        <td>{{ $movimiento->items }}</td>
        <td>{{ $movimiento->tipo }}</td>
        <td>{{ $movimiento->kgrs }}</td>
        <td>{{ $movimiento->bultos }}</td>
        <td>{{ $movimiento->flete }}</td>
        <td>{{ $movimiento->neto }}</td>
        <td>{{ $movimiento->factura }}</td>
        <td>{{ $movimiento->panamaneto }}</td>
        <td>{{ $movimiento->panama1 }}</td>
        <td>{{ $movimiento->panama2 }}</td>
        <td>{{ $movimiento->franquicia }}</td>
    </tr>
    @endforeach
</table>