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
                                        Usuarios
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="javascript:void(0)" onclick="add('{{ route('users.add') }}')" class="ml-2">
                                        <i class=" fa-2x fa fa-plus-circle text-primary"></i>
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
                                                    <th>UserID</th>
                                                    <th>Username</th>
                                                    <th>Rol</th>
                                                    <th>Vincular tiendas</th>
                                                    <th>Nro tiendas asociadas</th>
                                                    <th>Tienda activa</th>
                                                    <th>Editar</th>
                                                    <th>Borrar</th>
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

@include('admin.users.modal')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'user_id', 'class':'text-center', orderable: false, searchable: false},
            {data: 'username'},
            {data: 'rol'},
            {data: 'vincular', 'class':'text-center'},
            {data: 'asociadas', 'class':'text-center'},
            {data: 'tienda'},
            {data: 'edit'},
            {data: 'destroy'},
            
        ]
    });      
</script>

@endsection