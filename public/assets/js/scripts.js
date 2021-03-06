// Botones comunes a todos los modales //

const add = (route) => {
    var elements = document.querySelectorAll('.is-invalid');
    jQuery.ajax({
        url: route,
        type: 'GET',
        success: function (data) {
            if (data['type'] == 'success') {
                jQuery("#insertByAjax").html(data['html']);
                jQuery(".btn-actualizar").hide()
                jQuery(".btn-guardar").show()
                jQuery('.editpopup').addClass('offcanvas-on');
            } else {
                toastr.error(data['msj'], 'Verifique');
            }
        }
    });
}

const store = (route) => {
    var elements = document.querySelectorAll('.is-invalid');
    var form = jQuery('#formData').serialize();
    jQuery.ajax({
        url: route,
        type: 'POST',
        data: form,
        beforeSend: function () {
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.remove('is-invalid');
            }
            jQuery('#loader').removeClass('hidden');
        },
        success: function (data) {
            jQuery('#loader').addClass('hidden');
            if (data['type'] == 'success') {
                closeModal();
                toastr.info('Creado', 'Registro');
                table.ajax.reload();
            } else {
                toastr.error(data['msj'], 'Verifique');
            }
        },
        error: function (data) {
            var lista_errores = "";
            var data = data.responseJSON;
            jQuery.each(data.errors, function (index, value) {
                lista_errores += value + '<br />';
                jQuery('#' + index).addClass('is-invalid');
                jQuery('#' + index).next().find('.select2-selection').addClass('is-invalid');
            });
            toastr.error(lista_errores, 'Verifique');
        },
        complete: function () {
            jQuery('#loader').addClass('hidden');
        }
    });
};

const edit = (id, route) => {
    var elements = document.querySelectorAll('.is-invalid');
    jQuery.ajax({
        url: route,
        type: 'GET',
        data: { id },
        success: function (data) {
            if (data['type'] == 'success') {
                jQuery("#insertByAjax").html(data['html']);
                jQuery(".btn-guardar").hide()
                jQuery(".btn-actualizar").show()
                jQuery('.editpopup').addClass('offcanvas-on');
            } else {
                toastr.error(data['html'], 'Verifique');
            }
        }
    });
}

const update = (route) => {
    jQuery('.btn-actualizar').prop('disabled', true);
    var elements = document.querySelectorAll('.is-invalid');
    var form = jQuery('#formData').serialize();

    jQuery.ajax({
        url: route,
        type: 'POST',
        data: form,
        beforeSend: function () {
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.remove('is-invalid');
            }
            jQuery('#loader').removeClass('hidden');
        },
        success: function (data) {
            if (data['type'] == 'success') {
                table.ajax.reload();
            } else {
                toastr.error(data['html'], 'Verifique');
            }
            jQuery('.btn-actualizar').prop('disabled', false);
        },
        error: function (data) {
            var lista_errores = "";
            var data = data.responseJSON;
            jQuery.each(data.errors, function (index, value) {
                lista_errores += value + '<br />';
                jQuery('#' + index).addClass('is-invalid');
            });
            toastr.error(lista_errores, 'Verifique');
        },
        complete: function () {
            jQuery('#loader').addClass('hidden');
        }
    });
};

const destroy = (id, route) => {
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
                    table.ajax.reload();
                    toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                    toastr.info("Eliminado ... ");
                }
            });
        }
    });
};

const closeModal = () => {
    document.getElementById("formData").reset();
    jQuery('.editpopup').removeClass('offcanvas-on');
}

//todos los select con la clase js-example-basic-single funcionan con select2 simple
jQuery('.js-example-basic-single').select2();

jQuery('.close_modal').on("click", function (event) {
    document.getElementById("formData").reset();
    jQuery('.editpopup').removeClass('offcanvas-on');
});

// Mostrar Input tipo password
jQuery('.show-t').on('click', function () {
    console.log(jQuery("#password").attr("type"))
    let x = jQuery("#password").attr("type");
    if (x === "password") {
        jQuery("#password").attr("type", "text");
    } else {
        jQuery("#password").attr("type", "password");
    }
});

(function ($) {
    $.extend(true, $.fn.dataTable.defaults, {
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        language: {
            decimal: ",",
            thousands: ".",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoPostFix: "",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            loadingRecords: "Cargando...",
            lengthMenu: "Mostrar _MENU_ registros",
            paginate: {
                first: "Primero",
                last: "??ltimo",
                next: "Siguiente",
                previous: "Anterior",
            },
            //processing: "Procesando...",
            processing: "<span class='fa-stack fa-lg'> <i class='fas fa-cog fa-spin fa-stack-2x fa-fw'></i> </span> Aguarde... ",
            search: "Buscar:",
            searchPlaceholder: "Palabra a buscar",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "Ning??n dato disponible en esta tabla",
            aria: {
                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                sortDescending: ": Activar para ordenar la columna de manera descendente",
            },
            //only works for built-in buttons, not for custom buttons
            buttons: {
                create: "Nuevo",
                edit: "Cambiar",
                remove: "Borrar",
                copy: "Copiar",
                csv: "fichero CSV",
                excel: "tabla Excel",
                pdf: "documento PDF",
                print: "Imprimir",
                colvis: "Visibilidad columnas",
                collection: "Colecci??n",
                upload: "Seleccione fichero....",
            },
            select: {
                rows: {
                    _: "%d filas seleccionadas",
                    0: "clic fila para seleccionar",
                    1: "una fila seleccionada",
                },
            },
        },
    });
})(jQuery);

// BARRA NAVEGACION / SUBMENUES

const $dropdown = jQuery(".dropdown");
const $dropdownToggle = jQuery(".dropdown-toggle");
const $dropdownMenu = jQuery(".dropdown-menu");
const showClass = "show";

jQuery(window).on("load resize", function() {
  if (this.matchMedia("(min-width: 768px)").matches) {
    $dropdown.hover(
      function() {
        const $this = jQuery(this);
        $this.addClass(showClass);
        $this.find($dropdownToggle).attr("aria-expanded", "true");
        $this.find($dropdownMenu).addClass(showClass);
      },
      function() {
        const $this = jQuery(this);
        $this.removeClass(showClass);
        $this.find($dropdownToggle).attr("aria-expanded", "false");
        $this.find($dropdownMenu).removeClass(showClass);
      }
    );
  } else {
    $dropdown.off("mouseenter mouseleave");
  }
});
