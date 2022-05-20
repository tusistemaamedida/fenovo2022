@isset($movimientos)
<div class="table-datapos">
    <div class="table-responsive">
        <table class=" table table-hover table-striped table-sm text-center">
            <tr class=" bg-dark text-black-50">
                <th>#</th>
                <th>Cod fenovo</th>
                <th class="w-25">Producto</th>
                <th>Medida</th>
                <th>Kgrs</th>
                <th>Presentación</th>
                <th>$_Costo</th>
                <th>Bultos</th>
                <th>$_Total</th>
                <th>Unidades</th>
                <th></th>
                <th></th>
            </tr>

            @php
            $total = 0;
            @endphp

            @foreach ($movimientos as $movimiento)

            @php
            $total += $movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos;
            @endphp

            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $movimiento->product->cod_fenovo }} </td>
                <td> {{ $movimiento->product->name }}</td>
                <td> {{ $movimiento->unit_type }}</td>
                <td> {{ number_format($movimiento->product->unit_weight*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }}</td>
                <td> {{ number_format($movimiento->unit_package,2) }} </td>
                <td> {{ $movimiento->cost_fenovo }}</td>
                <td> {{ $movimiento->bultos }}</td>
                <td> {{ number_format($movimiento->cost_fenovo*$movimiento->unit_package*$movimiento->bultos,2, ',', '.') }}</td>
                <td> {{ $movimiento->entry }} </td>
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
                <th>Totales </th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ number_format($movement->totalKgrs(),2, ',', '.') }}</th>
                <th></th>
                <th></th>
                <th>{{ $movimientos->sum('bultos')}}</th>
                <th>{{ number_format($total, 2,',', '.')}}</th>
                <th>{{ number_format($movimientos->sum('entry'), 2, ',', '.')}}</th>
                <th></th>
                <th></th>
            </tr>
        </table>
    </div>
</div>
@endisset