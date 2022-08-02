@extends('layouts.app-facturas')

@section('css')
    <link href="{{ asset('assets/api/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card card-custom gutter-b bg-transparent shadow-none border-0">

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card-header align-items-center  border-bottom-dark px-0">
                                    <div class="card-title mb-0">
                                        <h4 class="card-label mb-0 font-weight-bold text-body">
                                            Facturas generadas
                                        </h4>
                                    </div>
                                    <div class="icons d-flex">
                                        <a href="{{ route('mis.facturas') }}" title="Salir">
                                            <i class="fas fa-sign-out-alt text-dark"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                CUIT <span class=" text-dark font-weight-bolder">{{ $cuit }}</span>
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-12 ">
                                    <div class="card card-custom gutter-b bg-white border-0">
                                        <div class="card-body">
                                            <div class=" table-responsive" id="printableTable">
                                                <table id="productTable" class="display table-hover yajra-datatable">
                                                    <thead class=" bg-dark text-black-50">
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Fecha</th>
                                                            <th>Tienda</th>
                                                            <th>Titular</th>
                                                            <th>Cae</th>
                                                            <th>Importe</th>
                                                            <th>Factura</th>
                                                            <th>Panama</th>
                                                            <th>Flete</th>
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
            'bSort':false,
            ajax: "{{ route('mis.facturas.list') }}",
            columns: [
                {data: 'movement_id'},
                {data: 'fecha'},
                {data: 'tienda'},
                {data: 'cliente'},
                {data: 'cae'},
                {data: 'importe', 'class':'text-center', orderable: false, searchable: false},
                {data: 'url', 'class':'text-center', orderable: false, searchable: false},
                {data: 'panama', 'class':'text-center', orderable: false, searchable: false},
                {data: 'flete', 'class':'text-center', orderable: false, searchable: false},
            ]
        });
    </script>
@endsection
