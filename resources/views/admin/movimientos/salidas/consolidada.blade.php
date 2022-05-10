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
                                        Salidas consolidadas
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="{{ route('print.ordenConsolidada') }}" class="mt-1 mr-3">
                                        <i class="fa fa-print"></i> Orden
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

                                <div class="table-responsive">
                                    <table class="table table-condensed table-hover yajra-datatable text-center">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <td>#Orden</td>
                                                <td>Fecha</td>
                                                <td>Destino</td>
                                                <td>Item</td>
                                                <td>Tipo</td>
                                                <td>Kgrs</td>
                                                <td>Bultos</td>
                                                <td>Flete</td>
                                                <td>Neto</td>
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

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ordering: false,
        stateSave:true,
        processing: true,
        serverSide: true,
        dom: '<lfrtip>',
        ajax: "{{ route('index.ordenConsolidada') }}",
        columns: [
            {data: 'id', orderable:false,searchable: true},
            {data: 'date'},
            {data: 'destino', 'class':'text-left'},
            {data: 'items'},
            {data: 'type', 'class':'text-left', orderable:false,searchable: true},
            {data: 'kgrs', orderable:false,searchable: false},
            {data: 'bultos', orderable:false,searchable: false},
            {data: 'flete', orderable:false,searchable: false},
            {data: 'neto', orderable:false,searchable: false},
        ]
    });

</script>

@endsection