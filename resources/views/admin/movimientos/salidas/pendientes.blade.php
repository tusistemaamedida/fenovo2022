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
                                            Salidas en preparación
                                        </h4>
                                    </div>
                                    <div class="icons d-flex">
                                        <a href="{{ route('salidas.add') }}" class="ml-2">
                                            @if(in_array(Auth::user()->rol(), ['superadmin', 'admin','contable']) )
                                            <i class="fa fa-2x fa-plus-circle text-primary"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-12 ">
                            <div class="card card-custom gutter-b bg-white border-0">
                                <div class="card-body">

                                    <div class="table-datapos">
                                        <div class="table-responsive">
                                            <table class="display table-hover yajra-datatable">
                                                <thead>
                                                    <tr class="bg-dark text-white">
                                                        <th>Actualización</th>
                                                        <th>Identificación</th>
                                                        <th>Productos cargados</th>
                                                        <th>Destino</th>
                                                        <th>Cambiar pausa</th>
                                                        <th>Detalle</th>
                                                        <th>Imprimir</th>
                                                        <th>Borrar</th>
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

    @include('admin.movimientos.salidas.modalEliminar')
@endsection

@section('js')
    <script>
        var table = jQuery('.yajra-datatable')
            .DataTable({
                @include('partials.table.setting'),
                ordering: false,
                ajax: "{{ route('salidas.pendientes') }}",
                columns: [{
                        data: 'actualizacion',
                        'class': 'text-center',
                        searchable: false
                    },
                    {
                        data: 'list_id'
                    },
                    {
                        data: 'items',
                        'class': 'text-center',
                        searchable: false
                    },
                    {
                        data: 'destino'
                    },
                    {
                        data: 'pausar',
                        'class': 'text-center',
                        searchable: false
                    },
                    {
                        data: 'edit',
                        'class': 'text-center',
                        searchable: false
                    },
                    {
                        data: 'print',
                        'class': 'text-center',
                        searchable: false
                    },
                    {
                        data: 'destroy',
                        'class': 'text-center',
                        searchable: false
                    },

                ]
            });

        const motivoPendiente = (list_id) => {
            let route = '{{ route('salidas.pendienteMotivo') }}';
            var elements = document.querySelectorAll('.is-invalid');
            jQuery.ajax({
                url: route,
                type: 'GET',
                data: {
                    list_id
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#insertByAjax").html(data['html']);
                        jQuery('.editpopup').addClass('offcanvas-on');
                        jQuery("#motivo").focus();
                    } else {
                        toastr.error(data['msj'], 'Verifique');
                    }
                }
            })
        };

        const borrarPendiente = () => {

            let list_id = jQuery("#list_id").val();
            let motivo = jQuery("#motivo").val();

            if (motivo == 0) {
                jQuery("#motivo").focus();
                toastr.error("Complete el motivo");
                return
            }


            let route = '{{ route('salidas.pendiente.destroy') }}';
            ymz.jq_confirm({
                title: 'Eliminar',
                text: "confirma borrar registro ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    jQuery.ajax({
                        url: route,
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            list_id,
                            motivo
                        },
                        beforeSend: function() {
                            jQuery('#loader').removeClass('hidden');
                        },
                        success: function(data) {
                            if (data['type'] == 'success') {
                                table.ajax.reload();
                                toastr.options = {
                                    "progressBar": true,
                                    "showDuration": "300",
                                    "timeOut": "1000"
                                };
                                toastr.info("Eliminado ... ");
                            }
                        },
                        complete: function() {
                            jQuery('#loader').addClass('hidden');
                            jQuery('.editpopup').removeClass('offcanvas-on');
                        }
                    });
                }
            });
        };

        function pausarSalida(list_id, id_pausado) {
            jQuery.ajax({
                url: "{{ route('cambiar.pausa.salida') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    list_id,
                    id_pausado
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        table.ajax.reload();
                        toastr.options = {
                            "progressBar": true,
                            "showDuration": "300",
                            "timeOut": "1000"
                        };
                        toastr.info(data['msj']);
                    }
                }
            });
        }
    </script>
@endsection
