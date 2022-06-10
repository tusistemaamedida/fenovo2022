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
                                    Ajustar stocks entre depósitos
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="text-dark">Dónde <span class=" text-success">ingresa la
                                                mercadería </span></label>
                                        <fieldset class="form-group">
                                            <select class="rounded form-control bg-transparent" name="store_active"
                                                required>
                                                <option value="">Seleccione ...</option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}">
                                                        {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} -
                                                        {{ $store->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="text-dark">Desde dónde <span class=" text-danger">sale la
                                                mercadería</span></label>
                                        <fieldset class="form-group">
                                            <select class="rounded form-control bg-transparent" name="store_active"
                                                required>
                                                <option value="">Seleccione ...</option>
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}">
                                                        {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} -
                                                        {{ $store->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-custom gutter-b bg-white border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row font-weight-bold">
                                        <div class="col-12"> Producto</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <input type="hidden" name="movement_id" id="movement_id" value={{ $movement->id }} />
                                            {{ Form::select('product_id', $productos, null, ['id' => 'product_id', 'class' => 'js-example-basic-single form-control bg-transparent', 'placeholder' => 'Seleccione productos ...']) }}
                                        </div>
                                    </div>

                                </div>
                                <div class="col-8">
                                    <div id="dataTemp">
                                        @include('admin.products.detalleTemp')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card gutter-b bg-white border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <div id="dataConfirm">
                                        @include('admin.products.detalleConfirm')
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
        jQuery("#product_id").on('change', function() {
            const productId = jQuery("#product_id").val();
            jQuery.ajax({
                url: '{{ route('producto.check') }}',
                type: 'POST',
                data: {
                    productId
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#dataTemp").html(data['html']);
                        jQuery(".calculate").first().select();
                        if (jQuery("#unit_weight").val() == 0) {
                            toastr.error('PRODUCTO SIN "PESO UNITARIO"', 'Verifique');
                        }
                    }
                },
            });
        })

        const sumar = () => {
            let total = 0;
            let valido = true;

            jQuery('.calculate').each(function() {
                if (isNaN(parseFloat(jQuery(this).val()))) {
                    valido = false;
                }
            });

            if (valido) {
                jQuery('.calculate').each(function() {
                    let valor = parseFloat(jQuery(this).val());
                    let presentacion_input = jQuery(this).attr("id").split('_');
                    let presentacion = presentacion_input[1];

                    total = total + (valor * presentacion);
                });
                if (total > 0) {
                    jQuery('#btn-guardar-producto').removeClass("d-none");
                }
                jQuery('.total').val(total)
            } else {
                jQuery('#btn-guardar-producto').addClass("d-none");
                jQuery('.total').val(0)
            }
        }

        const guardarItem = (product_id, peso_unitario) => {

            jQuery('#loader').removeClass('hidden');

            const movement_id = jQuery("#movement_id").val();
            const unit_type = jQuery("#unit_type").val();
            const store_id = 1;

            let invoice = 0;
            let cyo = 0;

            // Definir subtype     
            if (jQuery("#subtype").val() == 'FACTURA') {
                invoice = 1;
            } else {
                if (jQuery("#subtype").val() == 'CYO') {
                    cyo = 1;
                }
            }

            let arrMovimientos = [];
            jQuery('.calculate').each(function() {
                if (isNaN(parseFloat(jQuery(this).val()))) {
                    valido = false;
                } else {
                    let presentacion_input = jQuery(this).attr("id").split('_');
                    let presentacion = presentacion_input[1];
                    let unit_package = presentacion;
                    let valor = parseFloat(jQuery(this).val());
                    let entry = (unit_type == 'K') ? (valor * presentacion) * peso_unitario : (valor *
                        presentacion);
                    let egress = 0;
                    let balance = 0;
                    let entidad_tipo = 'S';

                    if (entry > 0) {
                        let Movi = new Object();
                        Movi.movement_id = movement_id;
                        Movi.entidad_id = store_id;
                        Movi.entidad_tipo = entidad_tipo;
                        Movi.product_id = product_id;
                        Movi.unit_package = unit_package;
                        Movi.unit_type = unit_type;
                        Movi.invoice = invoice;
                        Movi.cyo = cyo;
                        Movi.bultos = valor;
                        Movi.entry = entry;
                        Movi.balance = 0;
                        Movi.egress = 0;
                        arrMovimientos.push(Movi);
                    }
                }
            });
            jQuery.ajax({
                url: '{{ route('product.ajuste-detalle.store') }}',
                type: 'POST',
                data: {
                    datos: arrMovimientos
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        actualizarIngreso();
                        jQuery("#dataTemp").html('');
                        jQuery("#product_id").val(null).trigger('change').select2('open');
                    }
                    if (data['type'] !== 'success') {
                        toastr.error(data['msj'], 'Verifique');
                    }
                }
            })

            jQuery('#loader').addClass('hidden');
        }

        const actualizarIngreso = () => {
            const id = jQuery("#movement_id").val();
            jQuery.ajax({
                url: '{{ route('detalle-movimiento.getMovements') }}',
                type: 'GET',
                data: {
                    id
                },
                success: function(data) {
                    if (data['type'] == 'success') {
                        jQuery("#dataConfirm").html(data['html']);
                    }
                },
            });
        }

        const borrarDetalle = (movement_id, product_id) => {
            const route = '{{ route('detalle-ingresos.destroy') }}';

            ymz.jq_confirm({
                title: 'Atención',
                text: "Ud eliminará el producto y todas sus presentaciones ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    jQuery.ajax({
                        url: route,
                        type: 'POST',
                        data: {
                            movement_id,
                            product_id
                        },
                        success: function(data) {
                            if (data['type'] == 'success') {
                                jQuery("#dataConfirm").html(data['html']);
                                toastr.options = {
                                    "progressBar": true,
                                    "showDuration": "300",
                                    "timeOut": "1000"
                                };
                                toastr.info("Eliminado ... ");
                            }
                        }
                    })
                }
            })
        }

        const destroy_local = (id, route) => {
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
                            id: id
                        },
                        success: function(data) {
                            if (data['type'] == 'success') {
                                let ruta = "{{ route('ingresos.index') }}";
                                window.location = ruta;
                            }
                        }
                    });
                }
            });
        };

        const close_compra = (id) => {

            ymz.jq_confirm({
                title: 'Compra ',
                text: "Confirma el cierre de la  compra ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {
                    let ruta = '{{ route('ingresos.close', ['id' => $movement->id]) }}';
                    window.location = ruta;
                }
            });
        };
    </script>
@endsection
