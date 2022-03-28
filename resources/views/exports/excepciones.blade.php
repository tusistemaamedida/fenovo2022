<table>
    <tr>
        <td colspan="7">{{ $data }}</td>
    </tr>
    @foreach($sessionOfertas as $sessionOferta)
    @foreach($sessionOferta->stores as $store)
    <tr>
        <td>{{ $store->cod_fenovo}}</td>
        <td>{{ date('d-m-Y', strtotime($sessionOferta->fecha_desde)) }}</td>
        <td>{{ date('d-m-Y', strtotime($sessionOferta->fecha_hasta)) }}</td>
        <td>{{ $sessionOferta->product->cod_fenovo}}</td>
        <td>{{ $sessionOferta->product->name}}</td>
        <td>{{ $sessionOferta->plist0neto}}</td>
        <td>{{ $sessionOferta->p1tienda}}</td>
        <td>{{ $sessionOferta->p1may}}</td>
    </tr>
    @endforeach
    @endforeach
</table>