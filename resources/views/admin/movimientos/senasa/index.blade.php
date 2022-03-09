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
                                    <h3 class="card-label mb-0 font-weight-bold text-body">
                                        Certificados Senasa
                                    </h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="javascript:void(0)" onclick="add('{{ route('senasa.add') }}')" class="ml-2">
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
                                                    <th>Patente</th>
                                                    <th>Habilitacion</th>
                                                    <th>Precintos</th>
                                                    <th>Destino</th>
                                                    <th>Vincular</th>
                                                    <th>Imprimir</th>
                                                    <th>Editar</th>
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

@include('admin.movimientos.senasa.modal')

@endsection

@section('js')

<script>
    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('senasa.index') }}",
        columns: [
            {data: 'patente_nro'},
            {data: 'habilitacion_nro'},
            {data: 'precintos'},
            {data: 'destino'},
            {data: 'vincular', 'class':'text-center', searchable: false},
            {data: 'print', 'class':'text-center', searchable: false},
            {data: 'edit', 'class':'text-center', searchable: false},
        ]
    });
</script>

@endsection