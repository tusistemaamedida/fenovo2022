@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="row mt-5 mb-3">
                    <div class="col-6">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Stock de productos en otras Friotekas
                        </h4>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <fieldset class="form-group">
                            <select class="rounded form-control bg-transparent" name="storeId" id="storeId">
                                <option value="">Seleccione frioteka </option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">
                                        {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT) }} - {{ $store->description }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="detalle">
                            
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        let route = '{{ route('productos.stock.deposito.detalle') }}';

        jQuery(document).ready(function() {

            jQuery('#storeId').select2({
                placeholder: 'Seleccione una frioteka ...',
            })

            if (localStorage.storeId){
                cargarDatos(localStorage.storeId)
            }

        });

        jQuery('#storeId').on('change', function() {
            localStorage.setItem('storeId', this.value);
            cargarDatos(this.value)
        })


        const cargarDatos = (id) => {
            jQuery.ajax({
                url: route,
                type: 'GET',
                data: {id},
                success: function(data) {                    
                    if (data['type'] == 'success') {
                        jQuery(".detalle").html(data['html']);
                    }
                }
            });
        }

    </script>
@endsection
