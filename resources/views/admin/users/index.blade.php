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
                                                    <th>ResetPassword</th>
                                                    <th>Vincular</th>
                                                    <th>TiendasAsociadas</th>
                                                    <th>TiendaActiva</th>
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
        lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        stateSave:false,
        processing: true,
        serverSide: true,
        ordering:true,
        dom: '<lfrtip>',
        ajax: "{{ route('users.index') }}",
        columns: [
            {data: 'user_id', 'class':'text-center', orderable: false, searchable: false},
            {data: 'username'},
            {data: 'rol'},
            {data: 'reset','class':'text-center', orderable: false, searchable: false},
            {data: 'vincular','class':'text-center', orderable: false, searchable: false},
            {data: 'asociadas','class':'text-center', orderable: false, searchable: false},
            {data: 'tienda', orderable: false, searchable: false},
            {data: 'edit', orderable: false, searchable: false},
            {data: 'destroy', orderable: false, searchable: false},
            
        ]
    });   
    
    const reset = (email, route) => {

        ymz.jq_confirm({
            title: 'Password',
            text: "confirma reset password ?",
            no_btn: "Cancelar",
            yes_btn: "Confirma",
            no_fn: function () {
                return false;
            },
            yes_fn: function () {
                jQuery.ajax({
                    url: route,
                    type: 'POST',
                    dataType: 'json',
                    data: { email },
                    success: function (data) {
                        table.ajax.reload();
                        toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                        toastr.info(data.msj);
                    }
                    
                });
            }
        });
    };

</script>

@endsection