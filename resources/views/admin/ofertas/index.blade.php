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
                                        Ofertas de precios vigentes
                                    </h4>
                                </div>
                                <div class="icons d-flex">
                                    <a href="javascript:void(0)" onclick="add('{{ route('oferta.add') }}')" class="ml-2">
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
                                <table class="display table-hover yajra-datatable">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>No</th>
                                            <th>Nombre del producto</th>
                                            <th>Desde</th>
                                            <th>Hasta</th>
                                            <th>Vincular</th>
                                            <th>Asociadas</th>
                                            <th></th>
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

@include('admin.ofertas.modal')

@endsection

@section('js')

<script>
    jQuery("#product_id").select2({
        placeholder: "Seleccione producto ... "
    });

    var table = jQuery('.yajra-datatable').DataTable({
        @include('partials.table.setting'),
        ajax: "{{ route('oferta.index') }}",
        columns: [
            {data: 'DT_RowIndex', 'class':'text-center col-1', orderable: false, searchable: false},
            {data: 'producto'},
            {data: 'fechadesde'},
            {data: 'fechahasta'},
            {data: 'vincular', 'class':'text-center col-1', orderable: false, searchable: false},
            {data: 'asociadas', 'class':'text-center', orderable: false, searchable: false},
            {data: 'edit', 'class':'text-center', orderable: false, searchable: false},
            {data: 'destroy', 'class':'text-center', orderable: false, searchable: false},
        ]
    });
</script>

@endsection