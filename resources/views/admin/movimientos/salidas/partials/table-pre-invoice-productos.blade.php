<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless table-condensed table-hover text-body yajra-datatable">
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
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($m_productos))
                                    @php
                                        $i=0;
                                        $subtotal_product =0;
                                        $total_kgrs = 0;
                                        $total_unidades = 0;
                                        $total_bultos = 0;
                                        $total_iva = 0;
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($m_productos as $mp)
                                        @php
                                            $i++;
                                            $unit_price =  $mp->unit_price;
                                            $subtotal_product = $unit_price * $mp->unit_package * $mp->bultos ;
                                            $subtotal_product_format = number_format($subtotal_product, 2, ',', '');
                                            $total_bultos += $mp->bultos;
                                            $total_kgrs += $mp->product->unit_weight * $mp->unit_package * $mp->bultos;
                                            $total_iva += ($mp->invoice) ? $subtotal_product * ($mp->tasiva/100) :0;
                                            $subtotal += $subtotal_product;
                                        @endphp

                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{$mp->product->cod_fenovo}}</td>
                                            <td>
                                                @if($mp->circuito == 'CyO') <span style="font-size: 24px;vertical-align: -webkit-baseline-middle;"> * </span>@endif
                                                {{$mp->product->cod_fenovo}} {{$mp->product->name}}
                                            </td>
                                            <td>{{number_format($mp->unit_package,2)}}</td>
                                            <td>{{$mp->bultos}}</td>
                                            <td>
                                                @if ($mp->unit_type == 'K')
                                                {{$mp->product->unit_weight * $mp->unit_package * $mp->bultos}}
                                                @else
                                                {{$mp->unit_package * $mp->bultos}}
                                                @endif
                                            </td>
                                            <td>${{ number_format($unit_price, 2, ',', '')}}</td>
                                            <td>
                                                @if($mp->invoice)
                                                {{ number_format($mp->tasiva,2)}} %
                                                @else
                                                0 %
                                                @endif
                                            </td>
                                            <td>${{ $subtotal_product_format }}</td>
                                            @if ($mostrar_check_invoice)
                                            <td class="text-center">
                                                @if($mp->circuito == 'R')
                                                    <i class="fa fa-ban" style="color:red"></i>
                                                @elseif($mp->circuito == 'CyO')
                                                    <i class="fa fa-check" style="color:green"></i>
                                                @else
                                                    <fieldset>
                                                        <div class="checkbox">
                                                            <input type="checkbox" class="checkbox-input" onclick="changeInvoice('{{$mp->id}}',{{$mp->product_id}})" id="invoice-{{$mp->product_id}}" @if($mp->invoice) checked="" @endif name="invoice-{{$mp->product_id}}">
                                                        </div>
                                                    </fieldset>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    @if ($mostrar_check_invoice)<td class="border-0  header-heading" scope="col"></td>@endif
                                </tr>
                                <tr class="bg-light">
                                    <td>TOTALES</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $total_bultos}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>${{number_format($total_iva, 2, ',', '');}}</td>
                                    <td>${{number_format($subtotal, 2, ',', '');}}</td>
                                   {{--  <td>
                                        <input type="hidden" name="subTotal" id="subTotal" value="{{ $subtotal +$total_iva }}">
                                    </td> --}}
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

<div class="col-lg-12 col-xl-12">
    <div class="card card-custom gutter-b bg-white border-0">
        <div class="card-body">
            <div class="row mt-5 justify-content-end">
                <div class="col-12 col-md-3">
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
                                <tr >
                                    <th colspan="2" class="border-0 font-size-h5 mb-0 font-size-bold text-dark" style="width: 100%">
                                        <a href="{{route('create.invoice',['movment_id' => $movement_id])}}" type="button"  class="btn btn-primary" style="width: 100%">
                                            <i class="fa fa-save"></i> Guardar
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery('#product_search').select2('open');

    var dataTable = jQuery(".yajra-datatable").DataTable({
        scrollY: 300,
        paging: false,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: 2 },
            { orderable: false, targets: 3 },
            { orderable: false, targets: 4 },
            { orderable: false, targets: 5 },
            { orderable: false, targets: 6 },
            { orderable: false, targets: 7 },
            { orderable: false, targets: 8 },
            { orderable: false, targets: 9 }
        ],
        order: [[1, 'asc']],
        iDisplayLength: -1,
    });
</script>
