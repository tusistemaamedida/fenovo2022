<table>
    <tr>
        <td colspan="4">{{ $data }}</td>
    </tr>
    @foreach($sessionPrices as $sessionPrice)
    <tr>
        <td>{{ date('d-m-Y', strtotime($sessionPrice->fecha_actualizacion)) }}</td>
        <td>{{ $sessionPrice->product->cod_fenovo}}</td>
        <td>{{ $sessionPrice->product->name}}</td>
        <td>{{ $sessionPrice->plist1 }}</td>
    </tr>
    @endforeach
</table>