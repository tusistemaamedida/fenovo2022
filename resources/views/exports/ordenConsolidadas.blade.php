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
        <td>{{ number_format($movimiento->factura_neto, 2) }}</td>
        <td>{{ number_format($movimiento->panama_nro, 0) }}</td>
        <td>{{ number_format($movimiento->panama_neto, 2) }}</td>
        <td>{{ number_format($movimiento->flete_nro, 0) }}</td>
        <td>{{ number_format($movimiento->flete_neto, 2) }}</td>
    </tr>
    @endforeach
</table>