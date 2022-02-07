@isset($movimientos)
<table class=" table table-hover table-striped table-sm text-center">
    <tr>
        <th>#</th>
        <th>Cod fenovo</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th>Bultos</th>
        <th>Kilos</th>
    </tr>
    @foreach ($movimientos as $movimiento)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $movimiento->product->cod_fenovo }} </td>
        <td> {{ $movimiento->product->name }}</td>
        <td> {{ $movimiento->unit_package }} </td>
        <td> {{ $movimiento->bultos }}</td>
        <td> {{ number_format($movimiento->entry,2) }} </td>
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
        <th>Totales</th>
        <th>{{ number_format($movimientos->sum('bultos'), 2)}}</th>
        <th>{{ number_format($movimientos->sum('entry'), 2)}}</th>
    </tr>
</table>
@endisset