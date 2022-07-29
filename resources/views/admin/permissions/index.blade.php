@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="card-header align-items-center  border-bottom-dark">
                    <div class="card-title mb-0">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Permisos
                        </h4>
                    </div>
                    <div class="icons d-flex">
                        <a href="javascript:void(0)" onclick="add('{{ route('permissions.add') }}')">
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
                    <table class="display table-hover yajra-datatable">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>No</th>
                                <th>Nombre</th>
                                <th>Rol</th>
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

@include('admin.permissions.modal')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('permissions.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', 'class':'text-center col-1', orderable: false, searchable: false},
            {data: 'name'},
            {data: 'rol'},
            {data: 'edit', name: 'Editar', 'class':'text-center', orderable: false, searchable: false},
            {data: 'destroy', name: 'Borrar', 'class':'text-center', orderable: false, searchable: false},
        ]
    });      
</script>

@endsection