@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
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

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
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