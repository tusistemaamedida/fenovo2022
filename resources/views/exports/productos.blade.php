<table>
    <tr>
        <td colspan="25">{{ $data }}</td>
    </tr>
    @foreach($productos as $producto)
    <tr>
        <td>{{ $producto->cod_fenovo}}</td>
        <td>
            @if ($producto->cod_proveedor == null or $producto->cod_proveedor == '')
            &nbsp;
            @else
            {{ $producto->cod_proveedor }}
            @endif
        </td>
        <td>{{ $producto->proveedor}}</td>
        <td>{{ $producto->name}}</td>
        <td>{{ $producto->plistproveedor}}</td>
        <td>{{ $producto->descproveedor}}</td>
        <td>{{ $producto->costfenovo}}</td>
        <td>{{ $producto->mupfenovo}}</td>
        <td>{{ $producto->plist0neto}}</td>
        <td>{{ $producto->mup1}}</td>
        <td>{{ $producto->p1tienda}}</td>
        <td>{{ $producto->mupp1may}}</td>
        <td>{{ $producto->p1may}}</td>
        <td>{{ $producto->cantmay1}}</td>
        <td>{{ $producto->descp1}}</td>
        <td>{{ $producto->tasiva}}</td>
        <td>
            @if ($producto->barcode == null or $producto->barcode == '')
            &nbsp;
            @else
            {{ $producto->barcode}}
            @endif
        </td>
        <td>{{ $producto->unit_package}}</td>
        <td>{{ $producto->unit_type}}</td>
        <td>{{ $producto->unit_weight}}</td>
        <td>{{ $producto->mup2}}</td>
        <td>{{ $producto->p2tienda}}</td>
        <td>{{ $producto->package_palet}}</td>
        <td>{{ $producto->package_row}}</td>
        <td>
            @if ($producto->codigo == null or $producto->codigo == '')
            &nbsp;
            @else
            {{ $producto->codigo}}
            @endif
        </td>
    </tr>
    @endforeach
</table>