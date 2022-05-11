<table>
    <tr>
        <td colspan="14">{{ $data }}</td>
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
        <td>{{ $movimiento->factura_nro }}</td>
        <td>{{ $movimiento->factura_neto }}</td>
        <td>{{ $movimiento->panama_nro }}</td>
        <td>{{ $movimiento->panama_neto }}</td>
        <td>{{ $movimiento->flete_nro }}</td>
        <td>{{ $movimiento->flete_neto }}</td>
    </tr>
    @endforeach
</table>