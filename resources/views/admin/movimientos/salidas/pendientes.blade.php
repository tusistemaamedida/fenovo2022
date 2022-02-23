@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Salidas</li>
            </ol>
        </nav>
    </div>
</div>

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
                                        Listado
                                    </h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('salidas.add') }}" class="ml-2">
                                        <span class="bg-primary h-30px font-size-h5 w-30px d-flex align-items-center justify-content-center  rounded-circle shadow-sm ">
                                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="bi bi-plus white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                        </span>
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
                                <table class="display table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>Actualización</th>
                                            <th>Identificación</th>
                                            <th>Productos cargados</th>
                                            <th>Destino</th>
                                            <th>Detalle</th>
                                            <th>Print</th>
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

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.dom-button'),
        ordering: false,
        ajax: "{{ route('salidas.pendientes') }}",
        columns: [
            {data: 'actualizacion', 'class':'text-center', searchable: false},
            {data: 'list_id'},
            {data: 'items', 'class':'text-center', searchable: false},
            {data: 'destino'},
            {data: 'edit', 'class':'text-center', searchable: false},
            {data: 'print', 'class':'text-center', searchable: false},
            {data: 'destroy', 'class':'text-center', searchable: false},

        ]
    });

    const eliminarPendiente = (id, route) => {


        ymz.jq_confirm({
            title: 'Eliminar',
            text: "confirma borrar registro ?",
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
                    data: { id: id },
                    success: function (data) {
                        if (data['type'] == 'success') {
                            table.ajax.reload();
                            toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                            toastr.info("Eliminado ... ");
                        }
                    }
                });
            }
        });
    };


</script>

@endsection