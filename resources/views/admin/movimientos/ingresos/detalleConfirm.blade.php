@isset($movimientos)
<table class=" table table-hover table-striped table-sm">
    <tr>
        <th>#</th>
        <th>Cod fenovo</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th>Bultos</th>
        <th>Kilos</th>
        <th></th>
        <th></th>
    </tr>
    @foreach ($movimientos as $movimiento)
    <tr>
        <td> {{ $loop->iteration }}</td>
        <td> {{ $movimiento->product->cod_fenovo }} </td>
        <td> {{ $movimiento->product->name }}</td>
        <td> {{ $movimiento->unit_package }} </td>
        <td> {{ $movimiento->bultos }}</td>
        <td> {{ number_format($movimiento->entry,2) }} </td>
        <td> <a href="#" onclick="borrarDetalle('{{ $movimiento->movement_id}}', '{{ $movimiento->product_id }}')"><i class="fa fa-trash text-danger"></i></a> </td>
        <td> </td>
    </tr>
    @endforeach
    <tr>
        <th colspan="8">
            </hr </th>
    </tr>
    <tr>
        <th></th>
        <th>Totales </th>
        <th></th>
        <th></th>
        <th>{{ $movimientos->sum('bultos')}}</th>
        <th>{{ number_format($movimientos->sum('entry'), 2)}}</th>
        <th></th>
        <th></th>
    </tr>
</table>
@endisset