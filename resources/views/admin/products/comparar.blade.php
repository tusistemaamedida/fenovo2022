@extends('layouts.app')

@section('content')


    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="card-header align-items-center  border-bottom-dark px-0">
                    <div class="card-title mb-0">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Comparar stocks de productos
                        </h4>
                    </div>
                    <div class="icons d-flex">
                        <a href="{{ route('products.printCompararStock') }}" target="_blank">
                            <i class=" fa fa-file-csv "></i> Exportar
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
                    <div class="table-datapos">
                        <div class="table-responsive">
                            <table class=" table table-hover yajra-datatable text-center">
                                <thead class="text-body">
                                    <tr class="bg-light">
                                        <th>Proveedor</th>
                                        <th>Codigo Fenovo</th>
                                        <th>Nombre producto</th>
                                        <th>Costo</th>
                                        <th>Unidad</th>
                                        <th>Pres</th>
                                        <th>StockIni</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>StockFin</th>
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
    


@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('products.compararStock') }}",
        columns: [
            {data: 'proveedor', orderable: false},
            {data: 'cod_fenovo', orderable: false},
            {data: 'name', 'className': 'text-left',orderable: false},
            {data: 'costo', orderable: false, searchable: false},
            {data: 'unit_type', orderable: false, searchable: false},
            {data: 'unit_package', orderable: false, searchable: false},
            {data: 'stockInicioSemana', orderable: false, searchable: false},
            {data: 'ingresoSemana', 'className': 'text-success', orderable: false, searchable: false},
            {data: 'salidaSemana', 'className': 'text-danger', orderable: false, searchable: false},
            {data: 'stock', 'className': 'font-weight-bolder', orderable: false, searchable: false},
        ]
    });
</script>

@endsection