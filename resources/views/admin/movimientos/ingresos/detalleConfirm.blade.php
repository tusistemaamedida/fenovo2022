@isset($movimientos)
<table class=" table table-hover table-striped table-sm">
    <tr class=" bg-dark text-black-50">
        <th>#</th>
        <th class="w-50">Producto</th>
        <th class="text-center">Cod fenovo</th>
        <th class="text-center">Presentación</th>
        <th class="text-center">Bultos</th>
        <th class="text-center">Kilos</th>
        <th></th>
        <th></th>
    </tr>
    @foreach ($movimientos as $movimiento)
    <tr>
        <td> {{ $loop->iteration }}</td>
        <td> {{ $movimiento->product->name }}</td>
        <td class="text-center font-italic"> {{ $movimiento->product->cod_fenovo }} </td>
        <td class="text-center font-italic"> {{ $movimiento->unit_package }} </td>
        <td class="text-center"> {{ $movimiento->bultos }}</td>
        <td class="text-center"> {{ number_format($movimiento->entry,2) }} </td>
        <td> <a href="#" onclick="borrarDetalle('{{ $movimiento->movement_id}}', '{{ $movimiento->product_id }}')"><i class="fa fa-trash"></i></a> </td>
        <td> </td>
    </tr>
    @endforeach
    <tr>
        <th colspan="8">
            </hr>
        </th>
    </tr>
    <tr class=" bg-dark text-black-50">
        <th></th>
        <th>Totales </th>
        <th></th>
        <th></th>
        <th class="text-center">{{ $movimientos->sum('bultos')}}</th>
        <th class="text-center">{{ number_format($movimientos->sum('entry'), 2)}}</th>
        <th></th>
        <th></th>
    </tr>
</table>
@endisset