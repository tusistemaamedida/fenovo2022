<table>
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
        <td>{{ $producto->unit_type}}</td>
        <td>{{ $producto->stockReal() }}</td>
    </tr>
    @endforeach
</table>