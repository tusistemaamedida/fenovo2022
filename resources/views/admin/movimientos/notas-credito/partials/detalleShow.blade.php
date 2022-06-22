@isset($movement)

<div class="table-datapos">
    <div class="table-responsive">
        <table class=" table table-hover table-sm text-center">
            <tr class=" bg-dark text-white">
                <th>Cod fenovo</th>
                <th>Producto</th>
                <th>Unidad</th>
                <th>Presentación</th>
                <th>Bultos</th>
                <th>Cantidad</th>
                <th>Precio U</th>
                <th>Subtotal</th>
            </tr>

            @php
            $subtotal = 0;
            @endphp

            @foreach ($movement->movement_salida_products as $movimiento)
            <tr>
                <td> {{ $movimiento->product->cod_fenovo }} </td>
                <td class=" text-left"> {{ $movimiento->product->name }}</td>
                <td> {{ $movimiento->product->unit_type }}</td>
                <td> {{ $movimiento->unit_package }} </td>
                <td> {{ $movimiento->bultos }}</td>
                <td> {{ $movimiento->egress }} </td>
                <td> {{ $movimiento->unit_price }} </td>
                <td> {{ $movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package }} </td>
            </tr>
            @php
            $subtotal = $subtotal + ($movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package);
            @endphp

            @endforeach
            <tr>
                <th colspan="8"><br></th>
            </tr>
            <tr class=" bg-info text-white">
                <th>TOTALES</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $movement->movement_salida_products->sum('bultos') }}</th>
                <th></th>
                <th>{{ $subtotal }}</th>
            </tr>
        </table>
    </div>
</div>

@endisset