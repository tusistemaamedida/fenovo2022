<table>
    <tr>
        <td>Código</td>
        <td>Nombre</td>
        <td>PT1</td>
        <td>MT1</td>
        <td>PL1</td>
        <td>COML1</td>
        <td>PL2</td>
        <td>COML2</td>
    </tr>
    @foreach($productos as $producto)

    <tr>
        <td>{{ $producto->cod_fenovo    }}</td>
        <td>{{ $producto->name    }}</td>
        <td>{{ number_format($producto->product_price->p1tienda, 2, ',', '.') }}</td>
        <td>{{ number_format($producto->product_price->p1may, 2, ',', '.') }}</td>
        <td>{{ number_format($producto->product_price->plist1, 2, ',', '.') }}</td>
        <td>{{ number_format($producto->product_price->comlista1, 2, ',', '.') }}</td>
        <td>{{ number_format($producto->product_price->plist2, 2, ',', '.') }}</td>
        <td>{{ number_format($producto->product_price->comlista2, 2, ',', '.') }}</td>
    </tr>

    @endforeach
</table>
