<table>
    <tr>
        <td>Proveedor</td>
        <td>Cod Fenovo</td>
        <td>Producto</td>
        <td>Costo</td>
        <td>Tipo unidad</td>
        <td>Presentacion</td>
        <td>Stock Inicio</td>
        <td>Entradas</td>
        <td>Salidas</td>
        <td>Stock fin</td>
    </tr>
    @foreach($arrProductos as $producto)

    <tr>
        <td>{{ $producto->proveedor     }}</td>
        <td>{{ $producto->cod_fenovo    }}</td>
        <td>{{ $producto->nombre        }}</td>
        <td>{{ $producto->costo         }}</td>
        <td>{{ $producto->unidad        }}</td>
        <td>{{ $producto->presentacion  }}</td>
        <td>{{ $producto->stockini      }}</td>
        <td>{{ $producto->stockent      }}</td>
        <td>{{ $producto->stocksal      }}</td>
        <td>{{ $producto->stockfin      }}</td>
    </tr>

    @endforeach
</table>