<table>
    <tr>
        <td colspan="5">{{ $data }}</td>
    </tr>
    @foreach($sessionOfertas as $sessionOferta)
    <tr>
        <td>{{ $sessionOferta->product->cod_fenovo}}</td>
        <td>{{ $sessionOferta->product->name}}</td>
        <td>{{ $sessionOferta->p1tienda}}</td>
        <td>{{ date('d-m-Y', strtotime($sessionOferta->fecha_desde)) }}</td>
        <td>{{ date('d-m-Y', strtotime($sessionOferta->fecha_hasta)) }}</td>
    </tr>
    @endforeach
</table>