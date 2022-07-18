@isset($movement)

<div class="table-datapos">
    <div class="table-responsive">

        <table class="table table-hover table-sm text-center yajra-datatable" id="show-salida">
            <tr class=" bg-dark text-white">
                <th>#</th>
                <th>Cod fenovo</th>
                <th>Producto</th>
                <th>Presentación</th>
                <th>Unidad</th>
                <th>Circuito</th>
                <th>Bultos</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>

            @php
            $subtotal = 0;
            @endphp

            @foreach ($movement->movement_salida_products as $movimiento)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $movimiento->product->cod_fenovo }} </td>
                <td class=" text-left"> {{ $movimiento->product->name }}</td>
                <td> {{ $movimiento->unit_package }} </td>
                <td> {{ $movimiento->product->unit_type }} </td>
                <td> {{ $movimiento->circuito }} </td>
                <td> {{ $movimiento->bultos }}</td>
                <td> {{ ($movimiento->product->unit_type == 'K')?$movimiento->egress:$movimiento->bultos*$movimiento->unit_package}} </td>
                <td> {{ $movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package }} </td>
            </tr>
            @php
            $subtotal = $subtotal + ($movimiento->unit_price*$movimiento->bultos*$movimiento->unit_package);
            @endphp

            @endforeach
            <tr>
                <th colspan="9"><br></th>
            </tr>
            <tr class=" bg-info text-white">
                <th></th>
                <th>TOTALES</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ number_format($movement->movement_salida_products->sum('bultos'),2) }}</th>
                <th>{{ number_format($movement->movement_salida_products->sum('egress'),2) }} Kgrs</th>
                <th>{{ $subtotal }}</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
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