@extends('layouts.app')

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-2 py-2">
                    <li class="breadcrumb-item active" aria-current="page">
                       Crear Faturación
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <input type="hidden" name="movement_id" id="movement_id"  value="{{$movement_id}}">
                <div class="col-md-12" id="divAlertStock"></div>
                <div style="width: 100%" id="session_products_table"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        jQuery(document).ready(function() {
            cargarTablaProductos();
        });
        function cargarTablaProductos() {
            var movement_id = jQuery("#movement_id").val();
            var formData = {
                movement_id
            };
            var url = "{{ route('get.productos') }}";
            jQuery.ajax({
                url: url,
                type: 'GET',
                data: formData,
                beforeSend: function() {
                    jQuery('#loader').removeClass('hidden');
                    jQuery("#session_products_table").html('')
                },
                success: function(data) {
                    jQuery('#loader').addClass('hidden');
                    jQuery("#session_products_table").html(data['html']);
                },
                error: function(data) {},
                complete: function() {
                    jQuery('#loader').addClass('hidden');
                }
            });
        }

        function changeInvoice(id, product_id) {
            jQuery.ajax({
                url: "{{ route('change.product.invoice') }}",
                type: 'POST',
                data: {
                    id,
                    product_id
                },
                beforeSend: function() {
                    jQuery('#loader').removeClass('hidden');
                },
                success: function(data) {
                    if (data['type'] != 'success') {
                        toastr.error(data['msj'], 'Verifique');
                    }else{
                        toastr.success(data['msj'], 'Éxito');
                    }
                    jQuery('#loader').addClass('hidden');
                    setTimeout(() => {
                        cargarTablaProductos();
                    }, 300);
                },
                error: function(data) {},
                complete: function() {
                    jQuery('#loader').addClass('hidden');
                }
            });
        }
        function disableBtn(){
            jQuery("#btn-crear-invoice").attr('disabled',true);
            jQuery('#loader').removeClass('hidden');
        }
    </script>
@endsection
