@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                    <li class="breadcrumb-item active" aria-current="page">Salida de mercadería</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">

                @include('admin.movimientos.salidas.partials.form-select-cliente')

                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            @include('admin.movimientos.salidas.partials.form-select-product')
                            @include('admin.movimientos.salidas.partials.form-table-products')
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
                                            <tr class="d-flex align-items-center justify-content-between">
                                            <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                                    Subtotal
                                            </th>
                                            <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">$750</td>

                                            </tr>
                                            <tr class="d-flex align-items-center justify-content-between">
                                            <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                                    Discount(20%)
                                            </th>
                                            <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">$900</td>

                                            </tr>
                                            <tr class="d-flex align-items-center justify-content-between">
                                            <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">
                                                Tax
                                            </th>
                                            <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">10%</td>

                                            </tr>
                                            <tr class="d-flex align-items-center justify-content-between">
                                                <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">

                                                    Shipping Cost
                                                </th>
                                                <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">100</td>

                                            </tr>
                                            <tr class="d-flex align-items-center justify-content-between">
                                                <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark">

                                                    Coupon Code
                                                </th>
                                                <td class="border-0 justify-content-end d-flex text-black-50 font-size-base">20%</td>

                                            </tr>
                                            <tr class="d-flex align-items-center justify-content-between item-price">
                                            <th class="border-0 font-size-h5 mb-0 font-size-bold text-dark" >
                                                    TOTAL

                                            </th>
                                            <td class="border-0 justify-content-end d-flex text-dark font-size-base">$8100</td>

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
        </div>
@endsection

@section('js')
<script>
    jQuery("#to_type").change(function(){
        jQuery('#to').val(null).trigger('change');
    })

    jQuery('#to').select2({
        placeholder: 'Seleccione el cliente...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('get.cliente.salida') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    to_type: jQuery("#to_type").val()
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

    jQuery('#product_search').select2({
        placeholder: 'Seleccione por nombre, código fenovo, código de barras...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('search.products') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

</script>
@endsection
