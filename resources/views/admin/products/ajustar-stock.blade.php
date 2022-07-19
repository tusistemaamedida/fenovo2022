@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="card card-custom gutter-b bg-white border-0 mt-5">
        <div class="row mt-5 ml-3">
            <div class="col-xs-12 col-md-5">
                <h4> Ajustar stock {{ $product->cod_fenovo }} <span class="text-primary"> {{ $product->name }} </span>
                </h4>
            </div>
            <div class="col-xs-12 col-md-1 text-center">
                <h4>#ID {{ $product->id }} </h4>
            </div>

            <div class="col-xs-12 col-md-2">
                <h4>Peso <span class=" text-primary"> {{ $product->unit_weight }} </span> kgrs </h4>
            </div>
            <div class="col-xs-12 col-md-2">
                <h4>u.m. <span class=" text-primary"> {{ $product->unit_type }} </span> </h4>
            </div>
            <div class="col-xs-12 col-md-1">
            </div>
            <div class="col-xs-12 col-md-1">
                <a href="{{ route('product.historial', ['id' => $product->id]) }}">
                    <i class="fa fa-list" aria-hidden="true"></i> Historial
                </a>
            </div>
        </div>

        <div class="row m-3">
            <div class="card-body" style="min-height: 500px" id="info-stock">
                @include('admin.products.ajustar-stock-detail')
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        toastr.options.positionClass = 'toast-bottom-right';

        jQuery(document).ready(function() {
            jQuery("#txtAjustado").html(jQuery("#stockActual").val());
        })

        const Actualizar = () => {

            let total = jQuery("#cantidad").val();

            let valorActual = (jQuery("input[name='operacion']:checked").val() == 'suma') ?
                parseInt(jQuery("#stockActual").val()) + parseInt(total) :
                parseInt(jQuery("#stockActual").val()) - parseInt(total);

            jQuery("#stockAjustado").val(valorActual)
            jQuery("#txtAjustado").html(valorActual);
            jQuery("#observacion").val('Ajuste ' + jQuery("input[name='ajuste']:checked").val());
        }

        const VerOperacion = (value) => {
            jQuery("#txtOperacion").html(value.toUpperCase());
            Actualizar()
        }

        const VerTipo = (value) => {
            jQuery("#txtTipo").html(value.toUpperCase());
            Actualizar()
        }

        const VerAjuste = (value) => {
            jQuery("#txtAjuste").html(value.toUpperCase());
            Actualizar()
        }

        const sumar = (objeto) => {

            const unit_weight = parseInt(document.getElementById("unit_weight").value);
            let total = 0;
            let bultos = 0;
            let valido = true;

            jQuery('.calculate').each(function() {
                if (isNaN(parseInt(jQuery(this).val()))) {
                    jQuery(this).val(0)
                    jQuery(this).select()
                    valido = false;
                }
            });

            if (valido) {
                jQuery('.calculate').each(function() {
                    let valor = parseInt(jQuery(this).val());
                    let presentacion_input = jQuery(this).attr("id").split('_');
                    let unit_type = jQuery("#unit_type").val();
                    let presentacion = presentacion_input[1];

                    bultos = bultos + valor;
                    total = (unit_type == 'K') ? total + (valor * presentacion * unit_weight) : total + (valor *
                        presentacion);
                });
                total = total.toFixed(2);
            }

            jQuery("#txtCantidad").html(total);
            jQuery("#cantidad").val(total);
            jQuery("#bultos").val(bultos);

            Actualizar()
        }

        const ajustar = () => {

            if (jQuery('#cantidad').val() <= 0) {
                toastr.error('La cantidad de <strong>bultos debe ser superior a 0 </strong>', "Cantidad");
                jQuery('#cantidad').select()
                return false
            }

            if (jQuery('#observacion').val() == '') {
                toastr.error('Ingrese un comentario, por favor', "Observaciones");
                jQuery('#observacion').select()
                return false
            }

            let product_id      = jQuery("#product_id").val();
            let unit_price      = jQuery("#unit_price").val();
            let cost_fenovo     = jQuery("#cost_fenovo").val();
            let tasiva          = jQuery("#tasiva").val();
            let unit_type       = jQuery("#unit_type").val();
            let tipo_ajuste     = jQuery("input[name='tipo']:checked").val();
            let operacion       = jQuery("input[name='operacion']:checked").val();
            let peso_unitario   = jQuery("#unit_weight").val();

            let arrMovimientos = [];
            jQuery('.calculate').each(function() {
                if (isNaN(parseFloat(jQuery(this).val()))) {
                    valido = false;
                } else {
                    let presentacion_input = jQuery(this).attr("id").split('_');
                    let presentacion = presentacion_input[1];
                    let unit_package = presentacion;
                    let bultos = parseFloat(jQuery(this).val());
                    let cantidad = (unit_type == 'K') ? (bultos * presentacion) * peso_unitario : (bultos * presentacion);
                    let egress = 0;
                    let balance = 0;
                    let entidad_tipo = 'S';

                    if (cantidad > 0) {
                        let Movi = new Object();
                        Movi.operacion = operacion;
                        Movi.product_id = product_id;
                        Movi.cost_fenovo = cost_fenovo;
                        Movi.unit_price = unit_price;
                        Movi.tasiva = tasiva;
                        Movi.unit_type = unit_type;
                        Movi.circuito = tipo_ajuste;
                        Movi.unit_package = unit_package;
                        Movi.bultos = bultos;
                        Movi.cantidad = cantidad;
                        arrMovimientos.push(Movi);
                    }
                }
            })

            ymz.jq_confirm({
                title: 'Ajuste',
                text: "Confirma el ajuste ?",
                no_btn: "Cancelar",
                yes_btn: "Confirma",
                no_fn: function() {
                    return false;
                },
                yes_fn: function() {

                    var url = "{{ route('ajustar.stock.store') }}";
                    jQuery.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            datos: arrMovimientos
                        },
                        beforeSend: function() {
                            jQuery('#loader').removeClass('hidden');
                        },
                        success: function(data) {
                            if (data['type'] = 'success') {
                                jQuery("#info-stock").html(data['html']);
                                toastr.info(data['msj'], 'Stock ha sido ajustado');
                            } else {
                                toastr.error(data['msj'], 'Verifique');
                            }
                            jQuery('#loader').addClass('hidden');
                        },
                        error: function(data) {},
                        complete: function() {
                            jQuery('#loader').addClass('hidden');
                        }
                    });
                }
            })
        }
    </script>
@endsection
