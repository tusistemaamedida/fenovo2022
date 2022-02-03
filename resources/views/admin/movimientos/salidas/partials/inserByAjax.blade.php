<h4>{{$product->name}}</h4>
<br>
<div class="form-group">
    <label class="text-dark">Saldo Actual</label>
    <table class="table table-striped  text-body">
        <thead>
            <tr class="">
                <th class="border-0  header-heading" scope="col">Unidades</th>
                <th class="border-0  header-heading" scope="col">Unidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$stock}}</td>
                <td>{{$product->unit_type}}</td>
            </tr>
        </tbody>
    </table>
    <br>
</div>
<div class="row">
    <div class="col-4">
        <label class="text-dark">Presentación</label>
        <fieldset class="form-group">
            <select class="rounded form-control bg-transparent" name="unit_package" id="unit_package">
                @for ($i = 0; $i < count($presentaciones); $i++)
                    <option value="{{$presentaciones[$i]}}" @if ($i == 0) selected @endif>{{$presentaciones[$i]}}</option>
                @endfor
            </select>
        </fieldset>
    </div>
    <div class="col-4">
        <label class="text-dark">Cant. Bultos</label>
        <input type="number" id="quantity" name="quantity" class="form-control" value="0">
    </div>

    <div class="col-4">
        <label class="text-dark">Un. a enviar</label>
        <input type="number" id="unidades_a_enviar" name="unidades_a_enviar" class="form-control" value="0">
    </div>
</div>
<br>

<script>
    jQuery("#unit_package").change(function(){
        calcular_unidades_a_enviar()
    });

    jQuery("#quantity").keyup(function(){
        calcular_unidades_a_enviar()
    });

    jQuery("#quantity").change(function(){
        calcular_unidades_a_enviar()
    });

    function calcular_unidades_a_enviar(){
        var presentacion = jQuery("#unit_package").val();
        var cantidad = jQuery("#quantity").val();
        jQuery("#unidades_a_enviar").val(parseFloat(cantidad)*parseInt(presentacion));
    }

    jQuery("#sessionProductstore").click(function(){
        guardarProductoEnSession()
    })
    function guardarProductoEnSession(){
        var to_type = jQuery("#to_type").val();
        var product_id = jQuery("#product_search").val();
        var quantity = jQuery("#quantity").val();
        var to = jQuery("#to").val();
        var list_id = to_type+'_'+to;
        var formData =  {list_id, product_id, quantity, to};
        var url ="{{ route('store.session.product') }}";
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url:url,
            type:'POST',
            data:formData,
            beforeSend: function() {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('is-invalid');
                }
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if (data['type'] == 'success') {
                    closeModal()
                    cargarTablaProductos()
                } else{
                    jQuery('#' + data['index']).addClass('is-invalid');
                    jQuery('#'+  data['index']).next().find('.select2-selection').addClass('is-invalid');
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
    }
</script>
