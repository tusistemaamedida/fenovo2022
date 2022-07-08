<table>
    <tr>
        <td>Fecha</td>
        <td>Tipo</td>
        <td>Destino</td>
        <td>Factura</td>
        <td>Codigo</td>
        <td>Producto</td>
        <td>Unidad</td>
        <td>P.Costo</td>
        <td>Iva</td>
        <td>ImporteIva</td>
        <td>ImporteBruto</td>
        <td>Cantidad</td>
        <td>P.Venta</td>
    </tr>
    @foreach($arrMovimientos as $movimiento)
    <tr>
        <td>{{ $movimiento->fecha }}</td>
        <td>{{ $movimiento->type }}</td>
        <td>{{ $movimiento->destino }}</td>
        <td>{{ $movimiento->factura }}</td>
        <td>{{ $movimiento->cod_fenovo }}</td>
        <td>{{ $movimiento->producto }}</td>
        <td>{{ $movimiento->unidad }}</td>
        <td>{{ $movimiento->precio_costo }}</td>
        <td>{{ $movimiento->iva }}</td>
        <td>{{ $movimiento->importeiva }}</td>
        <td>{{ $movimiento->importeBruto }}</td>
        <td>{{ $movimiento->cantidad }}</td>
        <td>{{ $movimiento->precio_venta }}</td>
    </tr>
    @endforeach
</table>