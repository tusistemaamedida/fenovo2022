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
                                        Actualizaciones de precios
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
                                <table class="display table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>No</th>
                                            <th>Fecha actualización</th>
                                            <th>Cod Fenovo</th>
                                            <th>Nombre de producto</th>
                                            <th>$ P1 Tienda</th>
                                            <th>$ P2 Tienda</th>                                            
                                            <th>$ P1 Mayorista</th>
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

@include('admin.actualizaciones.modal')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('actualizacion.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center col-1', orderable: false, searchable: false},
            {data: 'fecha_actualizacion'},
            {data: 'cod_fenovo'},
            {data: 'product'},
            {data: 'p1tienda'},
            {data: 'p2tienda'},
            {data: 'p1may'},
            {data: 'destroy', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection