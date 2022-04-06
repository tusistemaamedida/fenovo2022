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
                                        Tiendas
                                    </h4>
                                </div>
                                <div class="icons d-flex">

                                    <a href="{{url('fletes')}}" class="mt-1 mr-3">
                                        Parámetros de fletes
                                    </a>
                                    
                                    <a href="{{ route('stores.add') }}" class="ml-2">
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
                                        <table class="table table-hover display yajra-datatable" style="width:100%">
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>No</th>
                                                    <th>Cod Fenovo</th>
                                                    <th>Tipo tienda</th>
                                                    <th>Nombre </th>
                                                    <th>Cuit</th>
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

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('stores.index') }}",
        columns: [
            {data: 'id', 'class':'text-center', orderable: false, searchable: false},
            {data: 'cod_fenovo'},
            {data: 'store_type', 'class':'text-center font-weight-bolder',},
            {data: 'description'},
            {data: 'cuit'},
            {data: 'edit', name: 'Editar', 'class':'text-center', orderable: false, searchable: false},
            {data: 'destroy', name: 'Borrar', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection