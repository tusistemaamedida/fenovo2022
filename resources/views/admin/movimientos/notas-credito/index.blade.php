@extends('layouts.app')

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">
                    Notas de crédito
                </li>
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
                                    <a href="{{ route('nc.add') }}" class="ml-2">
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
                                            <th>No</th>
                                            <th>Fecha</th>
                                            <th>Destino</th>
                                            <th>Tipo</th>
                                            <th>Factura Relacionada</th>
                                            <th>Comprobante NC</th>
                                            <th>Registro</th>
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

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        ajax: "{{ route('nc.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center', searchable: false},
            {data: 'date'},
            {data: 'destino'},
            {data: 'type'},
            {data: 'voucher_number',  'class':'text-center'},
            {data: 'comprobante_nc',  'class':'text-center'},
            {data: 'updated_at'},
            {data: 'acciones','class':'flex'},
        ]
    });

    function createInvoice(ruta){
        jQuery('#loader').removeClass('hidden');
        window.location.href = ruta
    }
</script>

@endsection