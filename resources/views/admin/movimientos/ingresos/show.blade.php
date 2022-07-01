@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                    <li class="breadcrumb-item active" aria-current="page">Ingreso de mercadería</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card gutter-b bg-white border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>Fecha</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Operación</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Tipo</label>
                        </div>
                        <div class="col-md-3 text-center">
                            <label>Origen</label>
                        </div>
                        <div class="col-md-2 text-center">
                            <label>Comprobante</label>
                        </div>
                    </div>
                    <div class="row font-weight-bolder">
                        <div class="col-md-2">
                            {{ date('d-m-Y', strtotime($movement->date)) }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->type }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->subtype }}
                        </div>
                        <div class="col-md-3 text-center">
                            {{ $movement->origenData($movement->type) }}
                        </div>
                        <div class="col-md-2 text-center">
                            {{ $movement->voucher_number }}
                        </div>
                    </div>
                </div>

                <div class="card gutter-b bg-white border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-xl-12">
                                @include('admin.movimientos.ingresos.show-detalle')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        @include('admin.movimientos.ingresos.modalMovimiento')
    @endsection

    @section('js')
        <script>
            const editarMovimiento = (detalleId, bultos, producto_id, cod_fenovo, nombre) => {
                jQuery("#detalle_id").val(detalleId);
                jQuery("#bultos_anterior").val(bultos);
                jQuery("#bultos_actual").val(bultos);
                jQuery("#producto_id").val(producto_id);
                jQuery("#cod_fenovo").html(cod_fenovo);
                jQuery("#nombre").html(nombre);
                jQuery('.movimientoPopup').addClass('offcanvas-on');
            }

            const actualizarMovimiento = () => {

                if (jQuery('#bultos_actual').val() == 0) {
                    toastr.error('La cantidad <strong>no puede ser 0 </strong>', "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }
                if (jQuery('#bultos_anterior').val() == jQuery('#bultos_actual').val()) {
                    toastr.error('Ingrese una cantidad <strong>diferente al anteriormente registrada </strong>',
                        "Cantidad");
                    jQuery('#bultos_actual').select()
                    return
                }

                let data = jQuery("#formDataCompra").serialize();

                var url = "{{ route('ajustar.ingreso.item') }}";
                jQuery.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function() {
                        jQuery('#loader').removeClass('hidden');
                    },
                    success: function(data) {
                        jQuery('.movimientoPopup').removeClass('offcanvas-on');
                        jQuery('#to').val(jQuery('#to').val()).trigger('change');
                    },
                    error: function(data) {},
                    complete: function() {
                        jQuery('#loader').addClass('hidden');
                    }
                });
            }

            const cerrarModal = () => {
                jQuery('.movimientoPopup').removeClass('offcanvas-on');
            }
        </script>
    @endsection
