@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="card card-custom gutter-b bg-white border-0 mt-5">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="card-header align-items-center  border-0">
                    <div class="card-title mb-0">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Ajustar de stock
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 mt-4 text-right">

            </div>
        </div>

        <div class="card-body" style="min-height: 500px" id="info-stock">
            @include('admin.products.ajustar-stock-detail')
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        toastr.options.positionClass = 'toast-bottom-right';

        $(document).ready(function() {
            jQuery("#txtAjustado").html($("#stockActual").val());
        })

        const Actualizar = () => {

            let total = jQuery("#cantidad").val();

            let valorActual = ($("input[name='operacion']:checked").val() == 'suma') ?
                parseFloat($("#stockActual").val()) + parseFloat(total) :
                parseFloat($("#stockActual").val()) - parseFloat(total);

            jQuery("#txtAjustado").html(valorActual);
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

            const unit_weight = parseFloat(document.getElementById("unit_weight").value);
            let total = 0;
            let bultos = 0;
            let observacion = jQuery("#observacion").val();
            let valido = true;

            jQuery('.calculate').each(function() {
                if (isNaN(parseFloat(jQuery(this).val()))) {
                    jQuery(this).val(0)
                    jQuery(this).select()
                    valido = false;
                }
            });

            if (valido) {
                jQuery('.calculate').each(function() {
                    let valor = parseFloat(jQuery(this).val());
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
                        data: jQuery("#ajuste-stock").serialize(),
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
