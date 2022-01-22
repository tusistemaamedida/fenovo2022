@extends('layouts.app')

@section('css')
<link href="{{asset('assets/api/datatable/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="subheader py-2 py-lg-6 subheader-solid">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-white mb-0 px-0 py-2">
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </nav>
    </div>
</div>

<div class="d-flex flex-column-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                            <div class="card-header align-items-center  border-bottom-dark px-0">
                                <div class="card-title mb-0">
                                    <h3 class="card-label mb-0 font-weight-bold text-body">Listado</h3>
                                </div>
                                <div class="icons d-flex">
                                    <a href="javascript:void(0)" onclick="addCustomer()" class="ml-2">
                                        <span class="bg-secondary h-30px font-size-h5 w-30px d-flex align-items-center justify-content-center  rounded-circle shadow-sm ">
                                            <svg width="25px" height="25px" viewBox="0 0 16 16" class="bi bi-plus white" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ">
                        <div class="card card-custom gutter-b bg-white border-0">
                            <div class="card-body">
                                <div class=" table-responsive" id="printableTable">
                                    @include('admin.customers.table')
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

@include('admin.customers.modal')

@endsection

@section('js')

<script>
    jQuery(document).ready( function () {
        jQuery('#customersTable').dataTable( {
            "pagingType": "simple_numbers",

            "columnDefs": [ {
            "targets"  : 'no-sort',
            "orderable": false,
            }]
        });
    });

    function addCustomer(){
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url:"{{ route('customers.add') }}",
            type:'GET',
            success:function(data){
                if(data['type'] == 'success'){
                    jQuery("#insertByAjax").html(data['html']);
                    jQuery(".btn-actualizar").hide()
                    jQuery(".btn-guardar").show()
                    jQuery('.editpopup').addClass('offcanvas-on');
                }else{
                    Swal.fire({
                        title: "Error!",
                        html: data['msj'],
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                }
            }
        });
    }

    jQuery(".btn-guardar").click(function(){
        var elements = document.querySelectorAll('.is-invalid');
        var form = jQuery('#formData').serialize();

        jQuery.ajax({
            url:"{{ route('customers.store') }}",
            type:'POST',
            data:form,
            beforeSend: function() {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('is-invalid');
                }
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if(data['type'] == 'success'){
                    Swal.fire({
                        title: "Exito!",
                        html: data['msj'],
                        type: "success",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                    setTimeout(function(){ location.reload() }, 1500);
                }else{
                    Swal.fire({
                        title: "Error!",
                        html: data['msj'],
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                }
            },
            error: function (data) {
                var lista_errores="";
                var data = data.responseJSON;
                jQuery.each(data.errors,function(index, value) {
                    lista_errores+=value+'<br />';
                    jQuery('#'+index).addClass('is-invalid');
                });
                Swal.fire({
                    title: "Error!",
                    html: lista_errores,
                    type: "error",
                    confirmButtonClass: "btn btn-primary",
                    buttonsStyling: !1
                }) ;
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    });


    function editCustomer(id){
        var elements = document.querySelectorAll('.is-invalid');
        jQuery.ajax({
            url:"{{ route('customers.edit') }}",
            type:'GET',
            data:{id},
            success:function(data){
                if(data['type'] == 'success'){
                    jQuery("#insertByAjax").html(data['html']);
                    jQuery(".btn-guardar").hide()
                    jQuery(".btn-actualizar").show()
                    jQuery('.editpopup').addClass('offcanvas-on');
                }else{
                    Swal.fire({
                        title: "Error!",
                        html: data['msj'],
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                }
            }
        });
    }

    jQuery(".btn-actualizar").click(function(){
        var elements = document.querySelectorAll('.is-invalid');
        var form = jQuery('#formData').serialize();

        jQuery.ajax({
            url:"{{ route('customers.update') }}",
            type:'POST',
            data:form,
            beforeSend: function() {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('is-invalid');
                }
                jQuery('#loader').removeClass('hidden');
            },
            success:function(data){
                if(data['type'] == 'success'){
                    Swal.fire({
                        title: "Exito!",
                        html: data['msj'],
                        type: "success",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                    setTimeout(function(){ location.reload() }, 1500);
                }else{
                    Swal.fire({
                        title: "Error!",
                        html: data['msj'],
                        type: "error",
                        confirmButtonClass: "btn btn-primary",
                        buttonsStyling: !1
                    }) ;
                }
            },
            error: function (data) {
                var lista_errores="";
                var data = data.responseJSON;
                jQuery.each(data.errors,function(index, value) {
                    lista_errores+=value+'<br />';
                    jQuery('#'+index).addClass('is-invalid');
                });
                Swal.fire({
                    title: "Error!",
                    html: lista_errores,
                    type: "error",
                    confirmButtonClass: "btn btn-primary",
                    buttonsStyling: !1
                })
            },
            complete: function () {
                jQuery('#loader').addClass('hidden');
            }
        });
    });

    jQuery('.close_modal').on("click", function(e){
        document.getElementById("formData").reset();
        jQuery('.editpopup').removeClass('offcanvas-on');
    });

    jQuery('.show_confirm').on('click', function (event) {
        var form = jQuery(this).closest("form");
        event.preventDefault();
        Swal.fire({
            title: 'Confirma eliminar?',
            text: "No podrá reversar este movimiento !",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si borrar'
        }).then((result) => {
            if (result.value) {
                form.submit()
            }
        })
    });

</script>

@endsection