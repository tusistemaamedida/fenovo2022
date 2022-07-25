@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                <div class="row mt-3">
                    <div class="col-6">
                        <h4 class="card-label mb-0 font-weight-bold text-body">
                            Productos en depósitos
                        </h4>
                    </div>
                    <div class="col-6">
                        <fieldset class="form-group">
                            <select class="rounded form-control bg-transparent" name="storeId" id="storeId">
                                <option value="">Seleccione depósito </option>
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
                            @include('admin.products.listDepositosDetalle')
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>

        jQuery('#storeId').on('change', function() {

            var route = '{{ route('productos.stock.deposito.detalle') }}';
            var id = this.value;

            jQuery.ajax({
                url: route,
                type: 'GET',
                data: {
                    id
                },
                success: function(data) {
                    
                    if (data['type'] == 'success') {
                        jQuery(".detalle").html(data['html']);
                    }
                }
            });
        })
    </script>
@endsection
