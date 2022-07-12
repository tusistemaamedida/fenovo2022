<table>
    <tr>
        <td>NroOrden</td>
        <td>FechaOperacion</td>
        <td>Tipo</td>
        <td>Destino</td>
        <td>Factura</td>
        <td>Codigo</td>
        <td>Producto</td>
        <td>Unidad</td>
        <td>Iva</td>
        <td>P.Costo</td>
        <td>ImporteIva</td>
        <td>ImporteBruto</td>
        <td>P.Venta</td>
        <td>Cantidad</td>
        <td>CostoTotal</td>
        <td>VentaTotal</td>
        <td>Utilidad</td>

    </tr>
    @foreach ($arrMovimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->id }}</td>
            <td>{{ $movimiento->fecha }}</td>
            <td>{{ $movimiento->type }}</td>
            <td>{{ $movimiento->destino }}</td>
            <td>{{ $movimiento->factura }}</td>
            <td>{{ $movimiento->cod_fenovo }}</td>
            <td>{{ $movimiento->producto }}</td>
            <td>{{ $movimiento->unidad }}</td>
            <td>{{ $movimiento->iva }}</td>
            <td>{{ $movimiento->precio_costo }}</td>
            <td>{{ $movimiento->importeiva }}</td>
            <td>{{ $movimiento->importeBruto }}</td>
            <td>{{ $movimiento->precio_venta }}</td>
            <td>{{ $movimiento->cantidad }}</td>
            <td>{{ $movimiento->costo_total }}</td>
            <td>{{ $movimiento->venta_total }}</td>
            <td>{{ $movimiento->utilidad_total }}</td>
        </tr>
    @endforeach
</table>
