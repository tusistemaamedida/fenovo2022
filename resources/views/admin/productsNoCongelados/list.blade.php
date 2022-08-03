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
                                Productos NO congelados
                            </h4>
                        </div>
                        <div class="icons d-flex">
                            <a href="{{route('product.add')}}" title="Agregar un producto ">
                                <i class="fa fa-2x fa-plus-circle text-primary"></i>
                            </a>
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
                            <table id="productTable" class=" table table-hover dataTable table-condensed yajra-datatable" role="grid">
                                <thead class="text-body">
                                    <tr class="bg-light ">
                                        <td>Tipo</td>
                                        <td>Codigo</td>
                                        <td>Nombre</td>
                                        <td>Stock</td>
                                        <td>Costo</td>
                                        <td>Proveedor</td>
                                        <td>Historial</td>
                                        <td>Editar</td>
                                        <td>Borrar</td>
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
        ajax: "{{ route('products.nc.list') }}",
        columns: [
            {data: 'categoria', orderable: false},
            {data: 'cod_fenovo', orderable: false},
            {data: 'name', orderable: false},
            {data: 'stock', class:'text-center', orderable: false, searchable: false},
            {data: 'costo', orderable: false, searchable: false},
            {data: 'proveedor', orderable: false},
            {data: 'historial', class:'text-center', orderable: false, searchable: false},
            {data: 'editar', class:'text-center', orderable: false, searchable: false},
            {data: 'borrar', class:'text-center', orderable: false, searchable: false},
        ]
    });

    const getDataStockProduct = (id, route) => {
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url: route,
            type: 'GET',
            data: { id },
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
        var url ="{{ route('ajustar.stock') }}";
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
