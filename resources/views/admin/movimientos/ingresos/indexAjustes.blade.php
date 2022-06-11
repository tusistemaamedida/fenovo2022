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
                                        Ajustes de stock entre depósitos
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('ingresos.ajustarStockDepositos.add') }}">
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
                                        <table class="display table-hover yajra-datatable">
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <th>Fecha</th>
                                                    <th>Origen</th>
                                                    <th>Destino</th>
                                                    <th>Items</th>
                                                    <th>Nro ajuste</th>
                                                    <th>Accion</th>
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
        ajax: "{{ route('ingresos.ajustarStockIndex') }}",
        ordering: false,
        columns: [
            {data: 'date', 'class':'text-center', searchable: false},
            {data: 'origen'},
            {data: 'destino'},
            {data: 'items', 'class':'text-center', searchable: false},
            {data: 'voucher', 'class':'text-center'},
            {data: 'accion', 'class':'text-center', searchable: false},
            {data: 'borrar', 'class':'text-center', searchable: false},
        ],
    });

</script>

@endsection