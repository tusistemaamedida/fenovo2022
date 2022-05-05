<table>
    <tr>
        <td>Proveedor</td>
        <td>Cod Fenovo</td>
        <td>Producto</td>
        <td>P lista 0</td>
        <td>Presentacion</td>
        <td>Tipo unidad</td>
        <td>Stock Kilos</td>
        <td>Stock Bultos</td>
    </tr>
    @foreach($productos as $producto)
    <tr>
        <td>{{ $producto->proveedor->name }} </td>
        <td>{{ $producto->cod_fenovo}}</td>
        <td>{{ $producto->name}}</td>
        <td>{{ $producto->product_price->plist0neto}}</td>
        <td>
            @php
            $presentacion = explode('|', $producto->unit_package);
            @endphp
            @if (count($presentacion)>1)
            0
            @else
            {{ $producto->unit_package}}
            @endif
        </td>
        <td>{{ $producto->unit_type }}</td>
        <td>{{ $producto->StockReal() }}</td>
        <td>
            @if($producto->StockReal() == 0)
            0
            @elseif (count($presentacion)>1)
            {{ (int) ($producto->StockReal() / $producto->unit_package[0]) }}
            @elseif ($producto->unit_package == 0)
            {{ (int) ($producto->StockReal() / 1) }}
            @else
            {{ (int) ($producto->StockReal() / $producto->unit_package) }}
            @endif
        </td>
    </tr>
    @endforeach
</table>