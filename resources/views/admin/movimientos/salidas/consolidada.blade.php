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
                                                <td>Fecha</td>
                                                <td>Destino</td>
                                                <td>#Orden</td>
                                                <td>Item</td>
                                                <td>Kgrs</td>
                                                <td>Tipo</td>
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
        ajax: "{{ route('print.ordenConsolidada') }}",
        columns: [
            {data: 'date'},
            {data: 'destino', 'class':'text-left'},
            {data: 'id', orderable:false,searchable: true},
            {data: 'items'},
            {data: 'kgrs', orderable:false,searchable: false},
            {data: 'type', orderable:false,searchable: true},
        ]
    });

</script>

@endsection