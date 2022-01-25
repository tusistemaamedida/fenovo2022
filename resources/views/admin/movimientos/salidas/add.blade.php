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
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <form>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label  class="text-body">Movimiento</label>
                                        <fieldset class="form-group mb-3">
                                            <select class="js-example-basic-single js-states form-control bg-transparent" name="to_type" id="to_type">
                                                <option value="VENTA">Venta</option>
                                                <option value="TRASLADO">Traslado</option>
                                                <option value="VENTACLIENTE">Venta a cliente</option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <label  class="text-body">Cliente</label>
                                        <fieldset class="form-group mb-3">
                                            <select class="js-example-basic-single js-states form-control bg-transparent" name="to" id="to">
                                            </select>
                                        </fieldset>
                                    </div>


                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label  class="text-body">Select Product</label>
                                    <fieldset class="form-group mb-3 d-flex">
                                        <input type="text" name="text"  class="form-control bg-white" id="exampleInputText" value="Polo Sweatshirt" >
                                        <a href="javascript:void(0)" class="btn-secondary btn ml-2 white pt-1 pb-1 d-flex align-items-center justify-content-center">ADD</a>
                                    </fieldset>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive"  id="printableTable">
                                        <table class="table table-striped  text-body">
                                            <thead>
                                            <tr class="">
                                                <th class="border-0  header-heading" scope="col">Name</th>
                                                <th class="border-0  header-heading" scope="col">Code</th>
                                                <th class="border-0  header-heading" scope="col">Quantity</th>
                                                <th class="border-0  header-heading" scope="col">Cost</th>
                                                <th class="border-0  header-heading" scope="col">Discount</th>
                                                <th class="border-0  header-heading" scope="col">Tax</th>
                                                <th class="border-0  header-heading" scope="col">Subtotal</th>
                                                <th class="border-0  header-heading text-right" scope="col">Clear</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="">

                                                <td class="">Mackbook</td>
                                                <td class="">2500</td>
                                                <td >
                                                    <input type="number" class="form-control" id="basicInput1" placeholder="Enter Quantity" value="0">
                                                </td>

                                                <td class=" ">166.03</td>
                                                <td class="">00</td>
                                                <td class="">25.5</td>
                                                <td class="">192.00</td>
                                                <td class="text-right">
                                                    <a href="#" class="confirm-delete" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                            <tr class="">

                                                <td class="">Mackbook</td>
                                                <td class="">2500</td>
                                                <td >
                                                    <input type="number" class="form-control" id="basicInput2" placeholder="Enter Quantity" value="0">
                                                </td>

                                                <td class=" ">166.03</td>
                                                <td class="">00</td>
                                                <td class="">25.5</td>
                                                <td class="">192.00</td>
                                                <td class="text-right">
                                                    <a href="#" class="confirm-delete" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>


                                            </tbody>
                                            <tfoot>
                                                <tr class="">
                                                <th class="border-0  header-heading" scope="col">Total</th>
                                                <th class="border-0  header-heading" scope="col"></th>
                                                <th class="border-0  header-heading" scope="col">0</th>

                                                <th class="border-0  header-heading" scope="col"></th>
                                                <th class="border-0  header-heading" scope="col">0.00</th>
                                                <th class="border-0  header-heading" scope="col">25.04</th>
                                                <th class="border-0  header-heading" scope="col">192.0</th>
                                                <th class="border-0  header-heading text-right" scope="col">
                                                    <a href="#" class="confirm-delete" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </th>

                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <label  class="text-body">Customer Address</label>
                            <fieldset class="form-group mb-3">
                                <select class="js-example-basic-single js-states form-control bg-transparent" name="state">
                                    <option value="AL">Joe road singapur </option>
                                </select>
                            </fieldset>
                            <div class="p-3 bg-light d-flex justify-content-between border-bottom">
                                <h5 class="font-size-bold mb-0">Shipping Cost:</h5>
                                <h5 class="font-size-bold mb-0">$20</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <label  class="text-body">Apply Coupon Code</label>
                            <fieldset class="form-group mb-3 d-flex">
                                <input type="text" name="text" class="form-control bg-white" id="exampleInputText2"  placeholder="Enter Coupon code">
                                <a href="javascript:void(0)" class="btn-secondary btn ml-2 white pt-1 pb-1 d-flex align-items-center justify-content-center">Apply</a>
                            </fieldset>
                            <div class="p-3 bg-light d-flex justify-content-between border-bottom">
                                <h5 class="font-size-bold mb-0">Coupon Code Applied of:</h5>
                                <h5 class="font-size-bold mb-0">20%</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <label  class="text-body">Payment Method</label>
                            <fieldset class="form-group mb-0">
                                <select class="js-example-basic-single js-states form-control bg-transparent" name="state">
                                    <option value="AL">Cash on delievry </option>
                                    <option value="AL">Credit Card </option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-custom gutter-b bg-white border-0" >
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label  class="text-body">Note</label>
                                    <div id="editor" class="bg-transparent text-dark">

                                    </div>
                                </div>
                            </div>
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
        cliente: true,
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
</script>
@endsection
