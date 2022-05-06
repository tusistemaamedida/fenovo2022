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
                                        Salidas cerrradas
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

                                <div class="table-datapos">
                                    <div class="table-responsive">
                                        <table class="display table-hover yajra-datatable">
                                            <thead>
                                                <tr class="bg-dark text-white">
                                                    <td>#</td>
                                                    <td>Fecha</td>
                                                    <td>Destino</td>
                                                    <td>Items</td>
                                                    <td>Tipo</td>
                                                    <td>Kgrs</td>
                                                    <td>FacturaNro</td>
                                                    <td class="text-center">Detalle</td>
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

@include('admin.movimientos.salidas.partials.modal-open-remito')

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
        ajax: "{{ route('salidas.index') }}",
        columns: [
            {data: 'id', 'class':'text-center', orderable:false,searchable: true},
            {data: 'date'},
            {data: 'destino'},
            {data: 'items'},
            {data: 'type', orderable:false},
            {data: 'kgrs', orderable:false},
            {data: 'factura_nro', 'class' : 'text-center'},
            {data: 'acciones', orderable:false, 'class' : 'text-left'},
        ]
    });

    jQuery('.yajra-datatable').on('draw.dt', function() {
        jQuery('[data-toggle="tooltip"]').tooltip();
    })

    function createRemito(id){
        var url ="{{ route('get.total.movement') }}";
        jQuery.ajax({
            url:url,
            type:'GET',
            data:{movement_id:id},
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if (data['type'] == 'success') {
                    jQuery("#movement_id_in_modal").val(id);
                    jQuery("#total_in_span").html(data['total']);
                    jQuery('#createRemito').addClass('offcanvas-on');
                } else{
                    toastr.error(data['msj'], 'Verifique');
                }
                jQuery('#loader').addClass('hidden');
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    };

    jQuery('#close_modal_salida').on('click', function () {
        jQuery('#createRemito').removeClass('offcanvas-on');
    });

</script>

@endsection
