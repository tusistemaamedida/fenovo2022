<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class="table table-striped  text-body yajra-datatable">
                                <thead>
                                    <tr class="">
                                        <th class="border-0  header-heading" scope="col">#</th>
                                        <th class="border-0  header-heading" scope="col">Nombre</th>
                                        <th class="border-0  header-heading" scope="col">Pres</th>
                                        <th class="border-0  header-heading" scope="col">Bultos</th>
                                        <th class="border-0  header-heading" scope="col">Kgrs.</th>
                                        <th class="border-0  header-heading" scope="col">P.U.</th>
                                        <th class="border-0  header-heading" scope="col">IVA</th>
                                        <th class="border-0  header-heading" scope="col">Subtotal</th>
                                        @if ($mostrar_check_invoice)
                                        <th class="border-0  header-heading text-center" scope="col">Factura</th>
                                        @endif
                                        <th class="border-0  header-heading text-center" scope="col">Edita</th>
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
                                    $total_iva = 0;
                                    $subtotal = 0;
                                    @endphp
                                    @foreach ($session_products as $session_product)
                                    @php
                                    $i++;
                                    $subtotal_product = $session_product->unit_price * $session_product->unit_package * $session_product->quantity ;
                                    $subtotal_product_format = number_format($subtotal_product, 2, ',', '');
                                    $total_bultos += $session_product->quantity;
                                    $total_kgrs += $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity;
                                    $total_iva += $subtotal_product * ($session_product->producto->product_price->tasiva/100);
                                    $subtotal += $subtotal_product;
                                    @endphp

                                    <tr class="">
                                        <td class="">{{ $i }}</td>
                                        <td class="">{{$session_product->producto->cod_fenovo}} {{$session_product->producto->name}}</td>
                                        <td class="">{{number_format($session_product->unit_package,2)}}</td>
                                        <td class="">{{$session_product->quantity}}</td>
                                        <td class="">{{$session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity}}</td>
                                        <td class="">${{ number_format($session_product->unit_price, 2, ',', '')}}</td>
                                        <td class="">{{ number_format($session_product->producto->product_price->tasiva,2)}} %</td>
                                        <td class="">${{ $subtotal_product_format }}</td>
                                        @if ($mostrar_check_invoice)
                                        <td class="text-center">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input" onclick="changeInvoice('{{$session_product->list_id}}',{{$session_product->producto->id}})" id="invoice-{{$session_product->producto->id}}" @if($session_product->invoice) checked="" @endif name="invoice-{{$session_product->producto->id}}">
                                                </div>
                                            </fieldset>
                                        </td>
                                        @endif
                                        <td class=" text-center">
                                            <a href="javascript:void(0)" onclick="editarMovimiento('{{$session_product->id}}', '{{$session_product->quantity}}', '{{$session_product->producto->cod_fenovo}}')">
                                                <i class=" fa fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        <td class=" text-center">
                                            <button type="button" onclick="deleteItemSession({{$session_product->id}},'{{route('delete.item.session.produc')}}')" class="btn btn-link confirm-delete" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">
                                            <hr />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="border-0  header-heading" scope="col">TOTALES</th>
                                        <th class="border-0  header-heading" scope="col"></th>
                                        <th class="border-0  header-heading" scope="col"></th>
                                        <th class="border-0  header-heading" scope="col">{{ $session_products->sum('quantity')}}</th>
                                        <th class="border-0  header-heading" scope="col">{{ number_format($total_kgrs,2) }}</th>
                                        <th class="border-0  header-heading" scope="col"></th>
                                        <th class="border-0  header-heading" scope="col">${{number_format($total_iva, 2, ',', '');}}</th>
                                        <th class="border-0  header-heading" scope="col">${{number_format($subtotal, 2, ',', '');}}</th>
                                        @if ($mostrar_check_invoice)<th class="border-0  header-heading" scope="col"></th>@endif
                                        <th class="border-0  header-heading" scope="col">
                                            <input type="hidden" name="subTotal" id="subTotal" value="{{ $subtotal +$total_iva }}">
                                        </th>
                                        <th class="border-0  header-heading" scope="col" style="float: right;">$ {{number_format($subtotal +$total_iva , 2, ',', '');}} </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="row justify-content-end">
                <div class="col-12 col-md-3">

                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class="table right-table mb-0">
                                <tbody>
                                    <tr class="align-items-center justify-content-between">
                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                            Subtotal
                                        </th>
                                        <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">
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
                                        <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
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
</div>

<script>
    jQuery(".yajra-datatable").DataTable({
        ordering: false,
    });
</script>
