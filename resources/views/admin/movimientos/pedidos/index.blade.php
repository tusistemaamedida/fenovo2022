@extends('layouts.app')

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h4 class="card-label mb-0 font-weight-bold text-body">
                                        Pedido solicitados
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class="table-datapos">
                                    <div class="table-responsive">
                                        <table class="display table-hover yajra-datatable">
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Origen pedido</th>
                                                    <th>Items</th>
                                                    <th>Nro pedido</th>
                                                    <th>Preparar</th>
                                                    <th>Detalle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
    </div>
</div>

@include('admin.movimientos.pedidos.modalIngreso')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('pedidos.index') }}",
        ordering: false,
        columns: [
            {data: 'id', 'class':'text-center', searchable: false},
            {data: 'date', 'class':'text-center', searchable: false},
            {data: 'origen'},
            {data: 'items', 'class':'text-center', searchable: false},
            {data: 'voucher',  'class':'text-center'},
            {data: 'edit', 'class':'text-center', searchable: false},
            {data: 'show', 'class':'text-center', searchable: false},
        ],
        });

     const editData = (id, route) =>{

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
</script>

@endsection
