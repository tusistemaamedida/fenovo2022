@extends('layouts.app')

@section('content')

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row mt-5">
                    <div class="col-lg-12 col-xl-6">
                        <h3 class="card-label mb-0 font-weight-bold text-body">
                            Salidas cerrradas
                        </h3>
                    </div>
                    <div class="col-lg-12 col-xl-6  text-right">
                        <a href="{{ route('salidas.menu.print') }}"> <i class=" fa fa-print"></i> Impresion | Exportación <i class="fas fa-file-csv"></i></a>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-lg-12 col-xl-12">
                        &nbsp;
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
                                            <th>Factura Nro</th>
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
        lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        stateSave:true,
        processing: true,
        serverSide: true,
        dom: '<lfrtip>',
        ajax: "{{ route('salidas.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center', orderable:false,searchable: false},
            {data: 'date'},
            {data: 'destino'},
            {data: 'type'},
            {data: 'factura_nro',  'class':'text-center'},
            {data: 'updated_at'},
            {data: 'acciones','class':'flex',orderable:false},
        ]
    });

    jQuery('.yajra-datatable').on('draw.dt', function() {
        jQuery('[data-toggle="tooltip"]').tooltip();
    })

</script>

@endsection
