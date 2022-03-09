@isset($movimientos)
<div class="table-datapos">
    <div class="table-responsive">
        <table class=" table table-hover table-sm text-center">
            <tr class=" bg-dark text-white">
                <th class="text-center">#</th>
                <th>Cod fenovo</th>
                <th>Producto</th>
                <th class="text-center">Presentación</th>
                <th class="text-center">Bultos</th>
                <th class="text-center">Kilos</th>
            </tr>
            @foreach ($movimientos as $movimiento)
            <tr>
                <td class=" text-center"> {{ $loop->iteration }}</td>
                <td> {{ $movimiento->product->cod_fenovo }} </td>
                <td> {{ $movimiento->product->name }}</td>
                <td class=" text-center"> {{ $movimiento->unit_package }} </td>
                <td class=" text-center"> {{ $movimiento->bultos }}</td>
                <td class=" text-center"> {{ number_format($movimiento->entry,2) }} </td>
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
            <tr class=" bg-info text-white">
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center">Totales</th>
                <th class="text-center">{{ number_format($movimientos->sum('bultos'), 2)}}</th>
                <th class="text-center">{{ number_format($movimientos->sum('entry'), 2)}}</th>
            </tr>
        </table>
    </div>
</div>
@endisset