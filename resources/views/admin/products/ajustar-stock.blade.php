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
                            Ajustar de stock de producto
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

        const sumar = (objeto) => {

            const unit_weight = parseFloat(document.getElementById("unit_weight").value);
            let total = 0;
            let bultos = 0;
            let observacion = 'Ajuste presentaciones : ';
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

                    if (valor > 0) {
                        observacion += valor + ' x ' + presentacion + ', ';
                    }

                    bultos = bultos + valor;
                    total = (unit_type == 'K') ? total + (valor * presentacion * unit_weight) : total + (valor *
                        presentacion);
                });
                total = total.toFixed(2);
            }

            jQuery("#txtCantidad").html(total);
            jQuery("#cantidad").val(total);
            jQuery("#bultos").val(bultos);
            jQuery("#observacion").val(observacion);

        }

        const ajustar = () => {

            if (jQuery('#cantidad').val() <= 0) {
                toastr.error('La cantidad de <strong>bultos debe ser superior a 0 </strong>', "Ajuste");
                return false
            }
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
                        toastr.error(data['msj'], 'Ajustado');
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
    </script>
@endsection
