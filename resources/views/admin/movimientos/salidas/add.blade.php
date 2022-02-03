@extends('layouts.app')

@section('css')
<style>
    .table tbody tr td{
        color: #1a3353;
    font-weight: 500;
    }
</style>
@endsection

@section('content')
    <div class="subheader py-2 py-lg-6 subheader-solid">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                    <li class="breadcrumb-item active" aria-current="page">Salida de mercadería</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">

                @include('admin.movimientos.salidas.partials.form-select-cliente')

                <b style="width: 100%" id="session_products_table"></b>
            </div>
        </div>
    </div>

    @include('admin.movimientos.salidas.partials.modal-product-details')
@endsection

@section('js')
<script>
    jQuery("#to_type").change(function(){
        jQuery('#to').val(null).trigger('change');
    })

    jQuery('#to').select2({
        placeholder: 'Seleccione el cliente...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('get.cliente.salida') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    to_type: jQuery("#to_type").val()
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

    jQuery('#product_search').select2({
        placeholder: 'Seleccione por nombre, código fenovo, código de barras...',
        minimumInputLength: 2,
        tags: false,
        ajax: {
            dataType: 'json',
            url: '{{ route('search.products') }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
        }
    });

    jQuery('#product_search').change(function(){
        var elements = document.querySelectorAll('.is-invalid');
        var id = jQuery("#product_search").val();
        if(id != ''){
            jQuery.ajax({
                url: "{{route('get.presentaciones')}}",
                type: 'GET',
                data: { id },
                beforeSend: function () {
                    jQuery('#loader').removeClass('hidden');
                },
                success: function (data) {
                    if (data['type'] == 'success') {
                        jQuery("#insertByAjax").html(data['html']);
                        jQuery('.editpopup').addClass('offcanvas-on');
                    } else if(data['type'] != 'clear') {
                        toastr.error(data['msj'], 'Verifique');
                    }

                    jQuery('#loader').addClass('hidden');
                },
                complete: function () {
                    jQuery('#loader').addClass('hidden');
                }
            });
        }
    });

    jQuery('#product_search').on('select2:open', function () {
        closeModal()
    });

    jQuery('#close_modal_presentaciones').on('click', function () {
        jQuery('#product_search').val(null).trigger('change');
    });

    jQuery('#to').change(function(){
        cargarTablaProductos();
    });

    function deleteItemSession(id,route){
        ymz.jq_confirm({
        title: 'Eliminar',
        text: "confirma borrar registro ?",
        no_btn: "Cancelar",
        yes_btn: "Confirma",
        no_fn: function () {
            return false;
        },
        yes_fn: function () {
            jQuery.ajax({
                url: route,
                type: 'POST',
                dataType: 'json',
                data: { id: id },
                success: function (data) {
                    toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                    toastr.success("Eliminado ... ");
                    setTimeout(() => {
                        cargarTablaProductos();
                    }, 500);
                }
            });
        }
    });
    }

    function cargarTablaProductos(){
        var to_type = jQuery("#to_type").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;
        var formData =  {list_id};
        var url ="{{ route('get.session.products') }}";
        jQuery.ajax({
            url:url,
            type:'GET',
            data:formData,
            beforeSend: function() {
                jQuery('#loader').removeClass('hidden');
                jQuery("#session_products_table").html('')
            },
            success:function(data){
                jQuery("#session_products_table").html(data['html'])
            },
            error: function (data) {
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    }

</script>
@endsection
