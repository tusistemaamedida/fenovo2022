@isset($movimientos)
<div class="table-datapos">
    <div class="table-responsive">
        <table class=" table table-hover table-striped text-center">
            <tr class=" bg-dark text-black-50">
                <th>Cod fenovo</th>
                <th class=" text-left">Producto</th>
                <th>Presentación</th>
                <th>Bultos</th>
                <th>Unidades</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($movimientos as $movimiento)
            <tr>
                <td> {{ $movimiento->product->cod_fenovo }} </td>
                <td class=" text-left"> {{ $movimiento->product->name }}</td>
                <td> {{ $movimiento->unit_package}} </td>
                <td> {{ $movimiento->bultos }}</td>
                <td> {{ $movimiento->entry }} </td>
                <td> <a href="#" onclick="borrarDetalle('{{ $movimiento->movement_id}}', '{{ $movimiento->product_id }}')"><i class="fa fa-trash"></i></a> </td>
                <td></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="7"> 
                    <input type="hidden" id="registros" name="registros" value="{{ $movimientos->count() }}">
                </td>
            </tr>
        </table>
    </div>
</div>
@endisset