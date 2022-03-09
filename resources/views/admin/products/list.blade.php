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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">
                                        Productos
                                    </h3>
                                </div>
                                <div class="icons d-flex">
                                    @can('products.create')
                                    <a href="{{ route('export.products') }}" class="mr-3">
                                        Exportar <i class="fas fa-file-csv"></i>
                                    </a>

                                    <a href="{{route('product.add')}}">
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
                                @include('admin.products.table-products')
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
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('products.list') }}",
        columns: [

            {data: 'cod_fenovo', orderable: false},
            {data: 'name', orderable: false},
            {data: 'stock', orderable: false, searchable: false},
            {data: 'senasa', orderable: false, searchable: false},
            {data: 'proveedor', orderable: false},
            @can('products.create')
            {data: 'editar', class:'text-center', orderable: false, searchable: false},
            {data: 'borrar', class:'text-center', orderable: false, searchable: false},
            @endcan
        ]
    });
</script>

@endsection