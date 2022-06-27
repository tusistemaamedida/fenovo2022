<fieldset class="form-group mb-3 d-flex">
    <select class="js-states form-control bg-transparent" name="buscar_producto" id="buscar_producto">
    </select>
</fieldset>


@section('js')
    @parent
    <script>
        jQuery('#buscar_producto').select2({
            placeholder: 'Ingrese codigo fenovo',
            minimumInputLength: 2,
            tags: false,
            ajax: {
                dataType: 'json',
                url: '{{ route('buscar.productos') }}',
                delay: 50,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
            }
        });


        jQuery('#buscar_producto').change(function() {
            var elements = document.querySelectorAll('.is-invalid');
            var id = jQuery("#buscar_producto").val();

            var url = '{{ route('product.ver', [':p_id']) }}';
            url = url.replace(':p_id', id);
            window.location = url

        })
    </script>
@endsection
