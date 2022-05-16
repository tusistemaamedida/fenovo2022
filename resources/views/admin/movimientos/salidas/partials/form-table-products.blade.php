<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12">

                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover text-body yajra-datatable">
                                <thead>
                                    <tr class="bg-dark text-white ">
                                        <th>#</th>
                                        <th>Cod</th>
                                        <th>Nombre</th>
                                        <th>Pres</th>
                                        <th>Bultos</th>
                                        <th>Cant</th>
                                        <th>P.U.</th>
                                        <th>IVA</th>
                                        <th>Subtotal</th>
                                        @if ($mostrar_check_invoice)
                                        <th>Factura</th>
                                        @endif
                                        <th>Edita</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($session_products))
                                    @php
                                    $i=0;
                                    $subtotal_product =0;
                                    $total_kgrs = 0;
                                    $total_unidades = 0;
                                    $total_bultos = 0;
                                    $total_iva = 0;
                                    $subtotal = 0;
                                    @endphp
                                    @foreach ($session_products as $session_product)
                                    @php
                                    $i++;
                                    $unit_price = ($session_product->invoice) ? $session_product->unit_price:$session_product->neto;
                                    $subtotal_product = $unit_price * $session_product->unit_package * $session_product->quantity ;
                                    $subtotal_product_format = number_format($subtotal_product, 2, ',', '');
                                    $total_bultos += $session_product->quantity;
                                    $total_kgrs += $session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity;
                                    $total_iva += ($session_product->invoice) ? $subtotal_product * ($session_product->producto->product_price->tasiva/100) :0;
                                    $subtotal += $subtotal_product;
                                    @endphp

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{$session_product->producto->cod_fenovo}}</td>
                                        <td>{{$session_product->producto->cod_fenovo}} {{$session_product->producto->name}}</td>
                                        <td>{{number_format($session_product->unit_package,2)}}</td>
                                        <td>{{$session_product->quantity}}</td>
                                        <td>
                                            @if ($session_product->unit_type == 'K')
                                            {{$session_product->producto->unit_weight * $session_product->unit_package * $session_product->quantity}}
                                            @else
                                            {{$session_product->unit_package * $session_product->quantity}}
                                            @endif
                                        </td>
                                        <td>${{ number_format($unit_price, 2, ',', '')}}</td>
                                        <td>
                                            @if($session_product->invoice)
                                            {{ number_format($session_product->producto->product_price->tasiva,2)}} %
                                            @else
                                            0 %
                                            @endif
                                        </td>
                                        <td>${{ $subtotal_product_format }}</td>
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
                                    <tr class="bg-light text-warning">
                                        <td>TOTALES</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $session_products->sum('quantity')}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>${{number_format($total_iva, 2, ',', '');}}</td>
                                        <td>${{number_format($subtotal, 2, ',', '');}}</td>
                                        @if ($mostrar_check_invoice)<td class="border-0  header-heading" scope="col"></td>@endif
                                        <td>
                                            <input type="hidden" name="subTotal" id="subTotal" value="{{ $subtotal +$total_iva }}">
                                        </td>
                                        <td>$ {{number_format($subtotal +$total_iva , 2, ',', '');}} </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <input type="hidden" name="total_from_session" id="total_from_session" value="{{$subtotal}}">
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
        iDisplayLength: -1,
    });
    jQuery('#product_search').select2('open');
    /*
    jQuery('.select2-container').addClass('select2-container--open');
    jQuery('.select2-container').click(function(){
        jQuery('.select2-container').addClass('select2-container--open');
    })
    window.addEventListener('scroll',(event) => {
        jQuery('.select2-container').removeClass('select2-container--open');
    }); */
</script>