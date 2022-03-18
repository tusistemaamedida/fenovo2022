<table>
    @foreach($descuentos as $descuento)
    <tr>
        <td>{{ $descuento->codigo}}</td>
        <td>{{ $descuento->descripcion}}</td>
        <td>{{ number_format($descuento->descuento, 3, '.', ',') }}</td>
        <td>{{ number_format($descuento->cantidad, 2, '.', ',') }}</td>
    </tr>
    @endforeach
</table>