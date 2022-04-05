<script>

    jQuery("#fecha_actualizacion").change(function(){
        validateBtn()
    })

    jQuery("#fecha_desde").change(function(){
        validateBtn()
    })

    jQuery("#fecha_hasta").change(function(){
        validateBtn()
    })

    function validateBtn(){
        var fecha       = jQuery("#fecha_actualizacion").val();
        var fecha_desde = jQuery("#fecha_desde").val();
        var fecha_hasta = jQuery("#fecha_hasta").val();
        if(fecha != '' || (fecha_desde != '' && fecha_hasta != '')){
            jQuery("#btn_product").attr('disabled',false);
        }else{
            jQuery("#btn_product").attr('disabled',true);
        }
    }

    jQuery("#plistproveedor").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#descproveedor").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#contribution_fund").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });


    jQuery("#mupfenovo").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });
    jQuery("#muplist1").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });
    jQuery("#muplist2").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#p1tienda").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#descp1").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#p2tienda").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#descp2").keypress(function(event){
        if (event.which == 13 || event.keyCode == 13) {
            let validate = 0;
            calculatePrices(validate)
        }
    });

    jQuery("#descproveedor").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#mupfenovo").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#contribution_fund").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#tasiva").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#muplist1").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#muplist2").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#p1tienda").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#descp1").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#p2tienda").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#descp2").change(function(){
        let validate = 0;
        calculatePrices(validate)
    });

    jQuery("#cod_descuento").change(function(){
        getDescuento();
    });

    function getDescuento(){
        var cod_descuento = jQuery("#cod_descuento").val();
        jQuery.ajax({
            url:"{{ route('get.descuento.aplicado') }}",
            type:'GET',
            data:{cod_descuento},
            beforeSend: function() {},
            success:function(data){
                if(data['type'] == 'success'){
                    jQuery("#descp1").val(data['descp1']);
                }
            },
            error: function (data) {},
            complete: function () {}
        });
    }

    function calculatePrices(validate = 1){
        var text = "Aguarde por favor, se están claculando los precios..."
        var spanId = "#info-calculate";
        var elements = document.querySelectorAll('.is-invalid');
        var plistproveedor = jQuery("#plistproveedor").val();
        var descproveedor  = jQuery("#descproveedor").val();
        var contribution_fund = jQuery("#contribution_fund").val();
        var mupfenovo = jQuery("#mupfenovo").val();
        var tasiva    = jQuery("#tasiva").val();
        var muplist1  = jQuery("#muplist1").val();
        var muplist2  = jQuery("#muplist2").val();
        var p1tienda  = jQuery("#p1tienda").val();
        var descp1    = jQuery("#descp1").val();

        var p2tienda      = jQuery("#p2tienda").val();
        var descp2        = jQuery("#descp2").val();
        var cod_descuento = jQuery("#cod_descuento").val();

        var product_id = jQuery("#product_id").val();

        jQuery.ajax({
            url:"{{ route('calculate.product.prices') }}",
            type:'GET',
            data:{
                validate,
                plistproveedor,
                descproveedor,
                mupfenovo,
                contribution_fund,
                tasiva,
                muplist1,
                muplist2,
                p1tienda,
                descp1,
                descp2,
                p2tienda,
                cod_descuento,
                product_id
            },
            beforeSend: function() {
                jQuery(spanId).html(text)
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('is-invalid');
                }
            },
            success:function(data){
                if(data['type'] == 'success'){
                    jQuery("#costfenovo").val(data['costfenovo']);
                    jQuery("#plist0neto").val(data['plist0neto']);
                    jQuery("#plist0iva").val(data['plist0iva']);
                    jQuery("#plist1").val(data['plist1']);
                    jQuery("#comlista1").val(data['comlista1']);
                    jQuery("#plist2").val(data['plist2']);
                    jQuery("#comlista2").val(data['comlista2']);
                    jQuery("#mup1").val(data['mup1']);
                    jQuery("#p1may").val(data['p1may']);
                    jQuery("#mupp1may").val(data['mupp1may']);
                    jQuery("#mup2").val(data['mup2']);
                    jQuery("#p2may").val(data['p2may']);
                    jQuery("#mupp2may").val(data['mupp2may']);
                    jQuery("#descp2").val(data['descp2']);
                }else{
                    //if(data['descp1']) jQuery("#descp1").val(data['descp1']);
                    toastr.error(data['msj'],'ERROR!');
                }
                jQuery(spanId).html('')
            },
            error: function (data) {
                var lista_errores="";
                var data = data.responseJSON;
                jQuery.each(data.errors,function(index, value) {
                    lista_errores+=value+'<br />';
                    jQuery('#'+index).addClass('is-invalid');
                });
                toastr.error(lista_errores,'ERROR!');
            },
            complete: function () {
                jQuery(spanId).html('')
            }
        });
    }
</script>
