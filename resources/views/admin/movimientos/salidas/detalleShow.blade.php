@isset($movement)

<table class=" table table-hover table-striped table-sm text-center">
    <tr>
        <th>#</th>
        <th>Cod fenovo</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th></th>
        <th>Kilos</th>
    </tr>
    @foreach ($movement->movement_salida_products as $movimiento)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $movimiento->product->cod_fenovo }} </td>
        <td> {{ $movimiento->product->name }}</td>
        <td> {{ $movimiento->unit_package }} </td>
        <td> {{ $movimiento->bultos }}</td>
        <td> {{ number_format($movimiento->egress,2) }} </td>
    </tr>
    @endforeach
    <tr class=" bg-black">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Totales</th>
        <th>{{ $movement->movement_salida_products_total_kg[0]['suma'] }}</th>
    </tr>
</table>
@endisset