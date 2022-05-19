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
                                        Clientes
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="javascript:void(0)" onclick="add('{{ route('customers.add') }}')" class="ml-2">
                                        <i class="fa fa-2x fa-plus-circle text-primary"></i>
                                    </a>
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
                                                    <th>No</th>
                                                    <th>CLI_ID</th>
                                                    <th>Razon social</th>
                                                    <th>Tienda</th>
                                                    <th>L.Precios</th>
                                                    <th>Cuit</th>
                                                    <th>Email</th>
                                                    <th></th>
                                                    <th></th>
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

@include('admin.customers.modal')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('customers.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center', orderable: false, searchable: false},
            {data: 'id'},
            {data: 'razon_social'},
            {data: 'tienda'},
            {data: 'listprice_associate', 'class':'text-center'},
            {data: 'cuit'},
            {data: 'email'},
            {data: 'edit', name: 'Editar', 'class':'text-center', orderable: false, searchable: false},
            {data: 'destroy', name: 'Borrar', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection
