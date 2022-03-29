@isset($movement)

<div class="table-datapos">
    <div class="table-responsive">

<table class="table table-hover table-sm text-center" id="show-salida">
    <tr class=" bg-dark text-white">
        <th>#</th>
        <th>Cod fenovo</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th>Subtotal</th>
        <th>Bultos</th>
        <th>Kilos</th>
    </tr>

    @php
    $subtotal = 0;
    @endphp

    @foreach ($movement->movement_salida_products as $movimiento)
    <tr>
        <td> {{ $loop->iteration }}</td>
        <td> {{ $movimiento->product->cod_fenovo }} </td>
        <td> {{ $movimiento->product->name }}</td>
        <td> {{ $movimiento->unit_package }} </td>
        <td> {{ $movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package }} </td>
        <td> {{ $movimiento->bultos }}</td>
        <td> {{ number_format($movimiento->egress,2) }} </td>
    </tr>
    @php
    $subtotal = $subtotal + ($movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package);
    @endphp

    @endforeach
    <tr>
        <th colspan="7"><br></th>
    </tr>
    <tr class=" bg-info text-white">
        <th></th>
        <th>TOTALES</th>
        <th></th>
        <th></th>
        <th>{{ $subtotal }}</th>
        <th>{{ number_format($movement->movement_salida_products->sum('bultos'),2) }}</th>
        <th>{{ number_format($movement->movement_salida_products->sum('egress'),2) }}</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th>FLETE ( {{ number_format($store->delivery_percentage,2) }} %)</th>
        <th>{{ number_format($movement->flete, 2) }}</th>
        <th></th>
        <th></th>
    </tr>
</table>

    </div>
</div>

@endisset
