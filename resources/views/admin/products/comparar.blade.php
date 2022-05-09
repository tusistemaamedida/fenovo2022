@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
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
                                <table id="productTable" class=" table table-hover display dataTable no-footer yajra-datatable text-center" role="grid">
                                    <thead class="text-body">
                                        <tr class="bg-dark text-white">
                                            <th>Proveedor</th>
                                            <th>Codigo</th>
                                            <th>Nombre producto</th>
                                            <th>Costo</th>
                                            <th>Unidad</th>
                                            <th>CantUni</th>
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
    </div>
</div>


@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        stateSave:true,
        processing: true,
        serverSide: true,
        ordering:false,
        dom: 'Bfrtip',
        buttons: ['excel'],
        ajax: "{{ route('products.compararStock') }}",
        columns: [
            {data: 'proveedor', orderable: false},
            {data: 'cod_fenovo', orderable: false},
            {data: 'name', 'className': 'text-left',orderable: false},
            {data: 'costo', orderable: false, searchable: false},
            {data: 'unit_type', orderable: false, searchable: false},
            {data: 'unit_package', orderable: false, searchable: false},
            {data: 'stockInicioSemana', orderable: false, searchable: false},
            {data: 'ingresoSemana', orderable: false, searchable: false},
            {data: 'salidaSemana', orderable: false, searchable: false},
            {data: 'stock', orderable: false, searchable: false},
        ]
    });
</script>

@endsection