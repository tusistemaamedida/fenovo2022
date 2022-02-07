<script src="{{asset('assets/js/filepicker.js')}}"></script>
<script src="{{asset('assets/js//cropper.min.js')}}"></script>
<script src="{{asset('assets/js/filepicker-ui.js')}}"></script>
<script src="{{asset('assets/js/filepicker-crop.js')}}"></script>
<script>
    jQuery("#btn-file").click(function(e){
        var cod_fenovo = jQuery("#cod_fenovo").val();
        if(cod_fenovo == ''){
            toastr.error('Ingrese un Código Fenovo','ERROR!');
            jQuery('#cod_fenovo').addClass('is-invalid');
            e.preventDefault()
        }else{
            imagenes();
        }
    });

    function imagenes(){
        jQuery('#filepicker').filePicker({
            url: "{{url('filepicker')}}",
            plugins: ['ui', 'drop','crop'],
            data: {
                _token: "{{ csrf_token() }}",
                cod_fenovo: jQuery("#cod_fenovo").val()
            }
        })
        .on('add.filepicker', function (e, data) {
            var cod_fenovo = jQuery("#cod_fenovo").val();
            if(cod_fenovo == ''){
                Swal.fire({
                    title: "Error!",
                    html: 'Ingrese un código fenovo en el detalle del producto!',
                    type: "error",
                    confirmButtonClass: "btn btn-primary",
                    buttonsStyling: !1
                }) ;
                data.abort()
            }
        })
        .on('progress.filepicker', function (e, data) {
            jQuery('#loader').removeClass('hidden');
            setTimeout(() => {

            }, 150000);
        })
        .on('fail.filepicker', function (e, data) {
            console.log(data);
            alert('Oops! Something went wrong.');
        }).on('always.filepicker', function (e, data) {
            jQuery('#loader').addClass('hidden');
        });
    }

    function validateCode(){
        jQuery.ajax({
            url:"{{ route('product.validate.code') }}",
            type:'GET',
            data:{
                category:jQuery("#type_id").val(),
                cod_fenovo:jQuery("#cod_fenovo").val(),
            },
            beforeSend: function() {
                jQuery("#cod_fenovo").remove('is-invalid');
            },
            success:function(data){
                if(data['type'] != 'success'){
                    jQuery("#cod_fenovo").addClass('is-invalid');
                    jQuery("#cod_fenovo").focus();
                    toast('ERROR!',data['msj'],'top-right','error',3500);
                }
            },
            error: function (data) {
                toast('ERROR!',JSON.stringify(data),'top-right','error',3500);
            }
        });
    }

    if (jQuery.fn.timeago) {
        jQuery.timeago.settings.strings = jQuery.extend({}, jQuery.timeago.settings.strings , {
            seconds: 'few seconds', minute: 'a minute',
            hour: 'an hour', hours: '%d hours', day: 'a day',
            days: '%d days', month: 'a month', year: 'a year'
        });
    }
</script>

<!-- Upload Template -->
<script type="text/x-tmpl" id="uploadTemplate">
    <tr class="upload-template">
        <td class="column-preview">
            <div class="preview">
                <span class="fa file-icon-{%= o.file.extension %}"></span>
            </div>
        </td>
        <td class="column-name">
            <p class="name">{%= o.file.name %}</p>
            <span class="text-danger error">{%= o.file.error || '' %}</span>
        </td>
        <td colspan="2">
            <p>{%= o.file.sizeFormatted || '' %}</p>
        </td>
        <td>
            {% if (!o.file.autoUpload && !o.file.error) { %}
                <a href="#" class="action action-primary start" title="Upload">
                    <i class="fa fa-arrow-circle-o-up"></i>
                </a>
            {% } %}
            <a href="#" class="action action-warning cancel" title="Cancel">
                <i class="fa fa-ban"></i>
            </a>
        </td>
    </tr>
</script><!-- end of #uploadTemplate -->

<!-- Download Template -->
<script type="text/x-tmpl" id="downloadTemplate">
    {% o.timestamp = function (src) {
        return (src += (src.indexOf('?') > -1 ? '&' : '?') + new Date().getTime());
    }; %}
    <tr class="download-template">
        <td class="column-preview">
            <div class="preview">
                {% if (o.file.versions && o.file.versions.thumb) { %}
                    <a href="{%= o.file.url %}" target="_blank">
                        <img src="{%= o.timestamp(o.file.versions.thumb.url) %}" width="64" height="64"></a>
                    </a>
                {% } else { %}
                    <span class="fa file-icon-{%= o.file.extension %}"></span>
                {% } %}
            </div>
        </td>
        <td class="column-name">
            <p class="name">
                {% if (o.file.url) { %}
                    <a href="{%= o.file.url %}" target="_blank">{%= o.file.name %}</a>
                {% } else { %}
                    {%= o.file.name %}
                {% } %}
            </p>
            {% if (o.file.error) { %}
                <span class="text-danger">{%= o.file.error %}</span>
            {% } %}
        </td>
        <td class="column-size"><p>{%= o.file.sizeFormatted %}</p></td>
        <td class="column-date">
            {% if (o.file.time) { %}
                <time datetime="{%= o.file.timeISOString() %}">
                    {%= o.file.timeFormatted %}
                </time>
            {% } %}
        </td>
        <td>
            {% if (o.file.imageFile && !o.file.error) { %}
                <a href="#" class="action action-primary crop" title="Cortar">
                    <i class="fa fa-crop"></i>
                </a>
            {% } %}
            {% if (o.file.error) { %}
                <a href="#" class="action action-warning cancel" title="Cancelar">
                    <i class="fa fa-ban"></i>
                </a>
            {% } else { %}
                <a href="#" class="action action-danger delete" title="Eliminar">
                    <i class="fa fa-trash"></i>
                </a>
            {% } %}
        </td>
    </tr>
</script><!-- end of #downloadTemplate -->

<!-- Pagination Template -->
<script type="text/x-tmpl" id="paginationTemplate">
    {% if (o.lastPage > 1) { %}
        <ul class="pagination pagination-sm">
            <li {% if (o.currentPage === 1) { %} class="disabled" {% } %}>
                <a href="#!page={%= o.prevPage %}" data-page="{%= o.prevPage %}" title="Previous">&laquo;</a>
            </li>

            {% if (o.firstAdjacentPage > 1) { %}
                <li><a href="#!page=1" data-page="1">1</a></li>
                {% if (o.firstAdjacentPage > 2) { %}
                <li class="disabled"><a>...</a></li>
                {% } %}
            {% } %}

            {% for (var i = o.firstAdjacentPage; i <= o.lastAdjacentPage; i++) { %}
                <li {% if (o.currentPage === i) { %} class="active" {% } %}>
                    <a href="#!page={%= i %}" data-page="{%= i %}">{%= i %}</a>
                </li>
            {% } %}

            {% if (o.lastAdjacentPage < o.lastPage) { %}
                {% if (o.lastAdjacentPage < o.lastPage - 1) { %}
                    <li class="disabled"><a>...</a></li>
                {% } %}
                <li><a href="#!page={%= o.lastPage %}" data-page="{%= o.lastPage %}">{%= o.lastPage %}</a></li>
            {% } %}

            <li {% if (o.currentPage === o.lastPage) { %} class="disabled" {% } %}>
                <a href="#!page={%= o.nextPage %}" data-page="{%= o.nextPage %}" title="Next">&raquo</a>
            </li>
        </ul>
    {% } %}
</script><!-- end of #paginationTemplate -->
