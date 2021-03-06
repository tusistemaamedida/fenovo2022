@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                    <div class="card-header align-items-center  border-bottom-dark px-0">
                        <div class="card-title mb-0">
                            <h4 class="card-label mb-0 font-weight-bold text-body">
                                Productos
                            </h4>
                        </div>
                        <div class="icons d-flex">
                            @can('products.create')
                            <a href="{{ route('products.by.stocks') }}" class="mt-1 mr-3">
                                Stocks (F,R,CyO)
                            </a>

                            <a href="{{ route('products.compararStock') }}" class="mt-1 mr-3">
                                Comparar stocks
                            </a>

                            <a href="{{url('oferta')}}" title="Oferta de precios" class="mt-1 mr-3">
                                Ofertas
                            </a>

                            <a href="{{url('actualizacion')}}" title="Actualización de precios" class="mt-1 mr-3">
                                Actualizaciones
                            </a>

                            <a href="{{url('descuento')}}" title="Lista de descuentos" class="mt-1 mr-3">
                                Descuentos
                            </a>

                            <a href="{{route('product.add')}}" title="Agregar un producto ">
                                <i class="fa fa-2x fa-plus-circle text-primary"></i>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-custom gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTable" class=" table table-hover dataTable table-condensed display yajra-datatable" role="grid">
                                <thead class="text-body">
                                    <tr class="bg-light ">
                                        <td>Codigo</td>
                                        <td>Producto</td>
                                        <td>Unidad</td>
                                        <td>Proveedor</td>
                                        <td>Factura</td>
                                        <td>Remito</td>
                                        <td>CyO</td>
                                        <td>Total</td>
                                        <td>Ajustar Stock</td>
                                    </tr>
                                </thead>
                                <tbody class="kt-table-tbody text-dark">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.products.modal-ajuste')
@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        autoWidth: false,
        ajax: "{{ route('products.by.stocks') }}",
        columns: [
            {data: 'cod_fenovo', orderable: false},
            {data: 'name', orderable: false},
            {data: 'unit_type',class:'text-center', orderable: false, searchable: false},
            {data: 'proveedor', orderable: false, searchable: true},
            {data: 'stock_f', orderable: false, searchable: true},
            {data: 'stock_r', class:'text-center', orderable: true, searchable: false},
            {data: 'stock_cyo', class:'text-center', orderable: true, searchable: false},
            {data: 'stock', orderable: true},
            {data: 'ajuste', class:'text-center', orderable: false, searchable: false}
        ]
    });

    const getDataStockProduct = (id, route) => {
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url: route,
            type: 'GET',
            data: { id, 'discriminado':true },
            success: function (data) {
                if (data['type'] == 'success') {
                    jQuery("#insertByAjax").html(data['html']);
                    jQuery(".btn-guardar").hide()
                    jQuery(".btn-actualizar").show()
                    jQuery('.editpopup').addClass('offcanvas-on');
                } else {
                    toastr.error(data['html'], 'Verifique');
                }
            }
        });
    }

    const cerrarModal = () =>{
        jQuery('.editpopup').removeClass('offcanvas-on');
    }

    const ajustarStock = () =>{
        var url ="{{ route('ajustar.by.stock') }}";
        jQuery.ajax({
            url:url,
            type:'POST',
            data:jQuery("#ajuste-stock").serialize(),
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if (data['type'] != 'success') {
                    toastr.error(data['msj'], 'Verifique');
                }else{
                    jQuery('.editpopup').removeClass('offcanvas-on');
                    toastr.info(data['msj'], 'Exito');
                    table.ajax.reload();
                }
                jQuery('#loader').addClass('hidden');
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }
</script>

@endsection
