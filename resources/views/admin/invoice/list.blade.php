@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                <li class="breadcrumb-item active" aria-current="page">Facturas generadas</li>
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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Listado
                                    </h3>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class=" table-responsive" id="printableTable">
                                    <table id="productTable" class="display table-hover yajra-datatable">
                                        <thead class="text-body">
                                            <tr>
                                                <th>#</th>
                                                <th>CAE</th>
                                                <th>Cliente</th>
                                                <th>CUIT</th>
                                                <th>Importe total</th>
                                                <th>Fecha</th>
                                                <th class="no-sort">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="kt-table-tbody text-dark">
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
@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        ajax: "{{ route('invoice.index') }}",
        columns: [
            {data: 'voucher_number', 'class':'text-center col-2'},
            {data: 'cae'},
            {data: 'client_name'},
            {data: 'client_cuit'},
            {data: 'imp_total'},
            {data: 'fecha'},
            {data: 'acciones'}
        ]
    });
</script>

@endsection