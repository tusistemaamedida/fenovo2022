@isset($movimientos)
<div class="table-datapos">
    <div class="table-responsive">
        <table class=" table table-hover table-striped table-sm">
            <tr class=" bg-dark text-black-50">
                <th>#</th>
                <th class="text-center">Cod fenovo</th>
                <th class="w-25">Producto</th>
                <th class="text-center">Unidad</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">$_Costo</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">$_Total</th>
                <th class="text-center">Kilos</th>
                <th></th>
                <th></th>
            </tr>

            @php
                $total = 0;
            @endphp

            @foreach ($movimientos as $movimiento)

            @php
                $total = $total+($movimiento->product->product_price->costfenovo*$movimiento->unit_package*$movimiento->bultos);
            @endphp

            <tr>
                <td> {{ $loop->iteration }}</td>
                <td class="text-center font-italic"> {{ $movimiento->product->cod_fenovo }} </td>
                <td> {{ $movimiento->product->name }}</td>
                <td class="text-center"> {{ $movimiento->product->unit_type }}</td>
                <td class="text-center"> {{ number_format($movimiento->unit_package,2) }} </td>
                <td class="text-center"> {{ $movimiento->cost_fenovo }}</td>
                <td class="text-center"> {{ $movimiento->bultos }}</td>
                <td class="text-center"> {{ number_format($movimiento->product->product_price->costfenovo*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }}</td>
                <td class="text-center"> {{ $movimiento->entry }} </td>
                <td> <a href="#" onclick="borrarDetalle('{{ $movimiento->movement_id}}', '{{ $movimiento->product_id }}')"><i class="fa fa-trash"></i></a> </td>
                <td> </td>
            </tr>
            @endforeach
            <tr>
                <th colspan="10">
                    </hr>
                </th>
            </tr>
            <tr class=" bg-dark text-black-50">
                <th></th>
                <th></th>
                <th></th>
                <th>Totales </th>
                <th></th>
                <th></th>
                <th class="text-center">{{ $movimientos->sum('bultos')}}</th>
                <th class="text-center">{{ number_format($total, 2,',', '.')}}</th>
                <th class="text-center">{{ number_format($movimientos->sum('entry'), 2, ',', '.')}}</th>
                <th></th>
                <th></th>
            </tr>
        </table>
    </div>
</div>
@endisset