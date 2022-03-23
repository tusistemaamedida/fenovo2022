<table>
    <tr>
        <td>cod_fenovo</td>
        <td>producto</td>
        <td>p1tienda</td>
        <td>fecha_desde</td>
        <td>fecha_hasta</td>
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