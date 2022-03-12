<table>
    <tr>
        <td colspan="26">{{ $data }}</td>
    </tr>
    @foreach($productos as $producto)
    <tr>
        <td>{{ $producto->cod_fenovo}}</td>
        <td>{{ $producto->cod_proveedor}}</td>
        <td>{{ $producto->proveedor}}</td>
        <td>{{ $producto->name}}</td>
        <td>{{ $producto->plistproveedor}}</td>
        <td>{{ $producto->descproveedor}}</td>
        <td>{{ $producto->costfenovo}}</td>
        <td>{{ $producto->mupfenovo}}</td>
        <td>{{ $producto->plist0neto}}</td>
        <td>{{ $producto->mup1}}</td>
        <td>{{ $producto->p1may}}</td>
        <td>{{ $producto->mupp1may}}</td>
        <td>{{ $producto->p1tienda}}</td>
        <td>{{ $producto->mupp1may}}</td>
        <td>{{ $producto->cantmay1}}</td>
        <td>{{ $producto->descp1}}</td>
        <td>{{ $producto->tasiva}}</td>
        <td>{{ $producto->barcode}}</td>
        <td>{{ $producto->unit_package}}</td>
        <td>{{ $producto->unit_type}}</td>
        <td>{{ $producto->unit_weight}}</td>
        <td>{{ $producto->mup2}}</td>
        <td>{{ $producto->p2tienda}}</td>
        <td>{{ $producto->package_palet}}</td>
        <td>{{ $producto->package_row}}</td>
        <td>{{ $producto->codigo}}</td>
    </tr>
    @endforeach    
</table>