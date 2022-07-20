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
                                Historial de ajustes
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
                                <table class=" table table-hover yajra-datatable">
                                    <thead class="text-body">
                                        <tr class="bg-dark text-white-50">
                                            <td>Fecha</td>                                
                                            <td>Codigo</td>                                
                                            <td>Producto</td>                                
                                            <td>Circuito</td>                                
                                            <td>Unidad</td>                                
                                            <td>Iva</td>                                
                                            <td>Pres</td>                                
                                            <td>Bultos</td>                                
                                            <td>Cant</td>                                
                                            <td>Costo</td>                                
                                            <td>$CostoTotal</td>                                
                                            <td>PrecioVta</td>                                
                                            <td>$VentaTotal</td>                                
                                            <td>Tipo</td>                                
                                            <td>Historial</td>          
                                            <td>Usuario</td>                      
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
        ajax: '{{ route('productos.ajusteHistoricoDeposito') }}',
        columns: [
            {data: 'fecha', 'class':'text-center', orderable: false, searchable: false},
            {data: 'cod_fenovo', 'class':'text-center', orderable: false, searchable: true},
            {data: 'producto', orderable: false, searchable: true},
            {data: 'circuito', 'class':'text-center', orderable: false, searchable: false},
            {data: 'unit_type', 'class':'text-center', orderable: false, searchable: false},
            {data: 'tasiva', 'class':'text-center', orderable: false, searchable: false},
            {data: 'unit_package', 'class':'text-center', orderable: false, searchable: false},
            {data: 'bultos', 'class':'text-center', orderable: false, searchable: false},
            {data: 'cantidad', 'class':'text-center', orderable: false, searchable: false},
            {data: 'cost_fenovo', 'class':'text-center', orderable: false, searchable: false},
            {data: 'costoTotal', 'class':'text-center font-weight-bolder', orderable: false, searchable: false},
            {data: 'unit_price', 'class':'text-center', orderable: false, searchable: false},
            {data: 'ventaTotal', 'class':'text-center font-weight-bolder', orderable: false, searchable: false},
            {data: 'estado', 'class':'text-center font-weight-bolder', orderable: false, searchable: true},
            {data: 'historial', 'class':'text-center font-weight-bolder', orderable: false, searchable: true},
            {data: 'usuario', orderable: false, searchable: true},
        ]
    });
</script>

@endsection
