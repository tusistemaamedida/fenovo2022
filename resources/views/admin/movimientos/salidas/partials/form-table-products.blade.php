<table class="table table-striped  text-body">
    <thead>
        <tr class="">
            <th class="border-0  header-heading" scope="col">#</th>
            <th class="border-0  header-heading" scope="col">Nombre</th>
            <th class="border-0  header-heading" scope="col">Unidad</th>
            <th class="border-0  header-heading" scope="col">Unidades</th>
            <th class="border-0  header-heading" scope="col">Bultos</th>
            <th class="border-0  header-heading" scope="col">Precio Unitario</th>
            <th class="border-0  header-heading" scope="col">IVA</th>
            <th class="border-0  header-heading" scope="col">Subtotal</th>
            <th class="border-0  header-heading" scope="col">Factura</th>
            <th class="border-0  header-heading text-right" scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @if (isset($session_products))
            @php
                $i=0;
                $subtotal_product =0;
                $total_unidades = 0;
                $total_bultos = 0;
                $total_precio_unitario = 0;
                $total_iva = 0;
                $subtotal = 0;
            @endphp
            @foreach ($session_products as $session_product)
                @php
                    $i++;
                    $subtotal_product = $session_product->quantity * $session_product->unit_price;
                    $subtotal_product_format = number_format($subtotal_product, 2, ',', '');
                    $total_unidades += $session_product->quantity;
                    $total_bultos += $session_product->quantity/$session_product->unit_package;
                    $total_precio_unitario += $session_product->unit_price;
                    $total_iva += $subtotal_product * $session_product->producto->product_price->tasiva;
                    $subtotal += $subtotal_product;
                @endphp

                <tr class="">
                    <td class="">{{ $i }}</td>
                    <td class="">{{$session_product->producto->name}}</td>
                    <td class="">{{$session_product->producto->unit_type}}</td>
                    <td class="">{{$session_product->quantity}}</td>
                    <td class="">{{$session_product->quantity/$session_product->unit_package}}</td>
                    <td class="">${{number_format($session_product->unit_price, 2, ',', '')}}</td>
                    <td class="">{{$session_product->producto->product_price->tasiva*100}}</td>
                    <td class="">${{ $subtotal_product_format }}</td>
                    <td class="" style="text-align: center">
                        <fieldset>
                            <div class="checkbox">
                              <input type="checkbox" class="checkbox-input" id="checkbox1" checked="" name="invoice-{{$session_product->producto->id}}">
                            </div>
                        </fieldset>
                    </td>

                    <td class="text-right">
                        <button type="button" onclick="deleteItemSession({{$session_product->id}},'{{route('delete.item.session.produc')}}')" class="confirm-delete" title="Eliminar">
                            <i class="fas fa-trash-alt"></i> Quitar
                        </button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr class="">
            <th class="border-0  header-heading" scope="col"></th>
            <th class="border-0  header-heading" scope="col"></th>
            <th class="border-0  header-heading" scope="col"></th>
            <th class="border-0  header-heading" scope="col">T.Unidades: {{$total_unidades}}</th>
            <th class="border-0  header-heading" scope="col">T. Bultos: {{$total_bultos}}</th>
            <th class="border-0  header-heading" scope="col">T. PU: ${{number_format($total_precio_unitario, 2, ',', '');}}</th>
            <th class="border-0  header-heading" scope="col">T. IVA: ${{number_format($total_iva, 2, ',', '');}}</th>
            <th class="border-0  header-heading" scope="col">Subtotal: ${{number_format($subtotal, 2, ',', '');}}</th>
            <th class="border-0  header-heading" scope="col"></th>
            <th class="border-0  header-heading" scope="col" style="float: right;">Total: ${{number_format($subtotal +$total_iva , 2, ',', '');}} </th>
        </tr>
    </tfoot>
</table>
