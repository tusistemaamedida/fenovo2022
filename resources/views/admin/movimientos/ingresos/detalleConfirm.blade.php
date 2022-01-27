@isset($movimientos)
<table class=" table table-hover table-striped table-sm text-center">

    <tr>
        <th>#</th>
        <th>Cod fenovo</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th>Cantidad</th>
        <th></th>
        <th></th>
    </tr>

    @foreach ($movimientos as $movimiento)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $movimiento->product->cod_fenovo }} </td>
        <td> {{ $movimiento->product->name }}</td>
        <td> {{ $movimiento->unit_package }} </td>
        <td> {{ $movimiento->entry }}</td>
        <td> <a href="#" onclick="borrarDetalle('{{ $movimiento->movement_id}}', '{{ $movimiento->product_id }}')"><i class="fa fa-trash text-danger"></i></a> </td>
        <td> </td>
    </tr>
    @endforeach
</table>
@endisset