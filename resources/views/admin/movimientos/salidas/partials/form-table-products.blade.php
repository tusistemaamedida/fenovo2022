<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0" >
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped  text-body">
                            <thead>
                                <tr class="">
                                    <th class="border-0  header-heading" scope="col">#</th>
                                    <th class="border-0  header-heading" scope="col">Nombre</th>
                                    <th class="border-0  header-heading" scope="col">Pres</th>
                                    <th class="border-0  header-heading" scope="col">Bultos</th>
                                    <th class="border-0  header-heading" scope="col">Kgrs.</th>
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
                                        $total_kgrs = 0;
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
                                            $total_bultos += $session_product->quantity;
                                            $total_kgrs += $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity;
                                            $total_precio_unitario += $session_product->unit_price;
                                            $total_iva += $subtotal_product * $session_product->producto->product_price->tasiva;
                                            $subtotal += $subtotal_product;
                                        @endphp

                                        <tr class="">
                                            <td class="">{{ $i }}</td>
                                            <td class="">{{$session_product->producto->name}}</td>
                                            <td class="">{{$session_product->unit_package}}</td>
                                            <td class="">{{$session_product->quantity}}</td>
                                            <td class="">{{$session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity}}</td>
                                            <td class="">${{number_format($session_product->unit_price, 2, ',', '')}}</td>
                                            <td class="">{{$session_product->producto->product_price->tasiva*100}}</td>
                                            <td class="">${{ $subtotal_product_format }}</td>
                                            <td class="" style="text-align: center">
                                                <fieldset>
                                                    <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input"
                                                    onclick="changeInvoice('{{$session_product->list_id}}',{{$session_product->producto->id}})"
                                                    id="invoice-{{$session_product->producto->id}}"
                                                    @if($session_product->invoice) checked="" @endif name="invoice-{{$session_product->producto->id}}">
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
                                    <th class="border-0  header-heading" scope="col">T. Bultos: {{$total_bultos}}</th>
                                    <th class="border-0  header-heading" scope="col">T. Kgrs: {{$total_kgrs}}</th>
                                    <th class="border-0  header-heading" scope="col">T. PU: ${{number_format($total_precio_unitario, 2, ',', '');}}</th>
                                    <th class="border-0  header-heading" scope="col">T. IVA: ${{number_format($total_iva, 2, ',', '');}}</th>
                                    <th class="border-0  header-heading" scope="col">Subtotal: ${{number_format($subtotal, 2, ',', '');}}</th>
                                    <th class="border-0  header-heading" scope="col"></th>
                                    <th class="border-0  header-heading" scope="col" style="float: right;">Total: ${{number_format($subtotal +$total_iva , 2, ',', '');}} </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0" >
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col-12 col-md-3">
                <div>
                    <table class="table right-table mb-0">

                        <tbody>
                            <tr class="align-items-center justify-content-between">
                                <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                        Subtotal
                                </th>
                                <td class="border-0 justify-content-end d-flex text-black-50 font-size-base" >
                                    ${{number_format($subtotal, 2, ',', '');}}
                                </td>
                            </tr>
                            <tr class=" align-items-center justify-content-between">
                                <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                        IVA
                                </th>
                                <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">
                                    ${{number_format($total_iva, 2, ',', '');}}
                                </td>
                            </tr>
                            <tr>
                                <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark" >
                                        TOTAL
                                </th>
                                <td class="border-0 justify-content-end d-flex text-dark font-size-base">
                                    ${{number_format($subtotal +$total_iva , 2, ',', '');}}
                                </td>
                            </tr>

                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
