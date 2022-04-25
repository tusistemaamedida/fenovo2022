<table>
    <tr>
        <td>fecha</td>
        <td>cod_fenovo</td>
        <td>producto</td>
        <td>p1tienda</td>
        <td>p2tienda</td>
        <td>p1may</td>
    </tr>
    @foreach($sessionPrices as $sessionPrice)
    <tr>
        <td>{{ date('d-m-Y', strtotime($sessionPrice->fecha_actualizacion)) }}</td>
        <td>{{ $sessionPrice->product->cod_fenovo}}</td>
        <td>{{ $sessionPrice->product->name}}</td>
        <td>{{ $sessionPrice->p1tienda}}</td>
        <td>{{ $sessionPrice->p2tienda}}</td>
        <td>{{ $sessionPrice->p1may}}</td>
    </tr>
    @endforeach
</table>