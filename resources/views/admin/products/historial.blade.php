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
                                Historial del producto {{ $producto->cod_fenovo }} - {{ $producto->name }} - Unidad <span class=" text-danger">{{ $producto->unit_type }} </span>
                            </h4>
                        </div>
                        <div class="icons d-flex">
                            <a href="{{ route('product.printHistorial',['id'=>$producto->id]) }}" class="mt-1 mr-3">
                                <i class=" fa fa-file-excel"></i> Exportar
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
                                <table class=" table table-hover display dataTable yajra-datatable">
                                    <thead class="text-body">
                                        <tr class="bg-light">
                                            <th>Fecha</th>
                                            <th>Tipo</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Observacion</th>
                                            <th>Presentacion</th>
                                            <th>Bultos</th>
                                            <th>C.</th>
                                            <th>Ingreso</th>
                                            <th>Salida</th>
                                            <th>Saldo</th>
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
        @include('partials.table.setting'),
        autoWidth: false,
        ajax: '{{ route('product.historial', ['id' => $producto->id] ) }}',
        columns: [
            {data: 'fecha', 'class':'text-center', orderable: false, searchable: false},
            {data: 'type', 'class':'text-left', orderable: false, searchable: true},
            {data: 'from', 'class':'text-left', orderable: false, searchable: true},
            {data: 'to', 'class':'text-left', orderable: false, searchable: true},
            {data: 'observacion', 'class':'text-left', orderable: false, searchable: true},
            {data: 'unit_package', 'class':'text-center', orderable: false, searchable: false},
            {data: 'bultos', 'class':'text-center', orderable: false, searchable: false},
            {data: 'circuito', 'class':'text-center', orderable: false, searchable: false},
            {data: 'entry', 'class':'text-center text-success', orderable: false, searchable: false},
            {data: 'egress', 'class':'text-center text-danger', orderable: false, searchable: false},
            {data: 'balance', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection
