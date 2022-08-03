<div class="row mt-2">
    <div class="col-12">
        <p class=" text-dark font-weight-bolder">
            @if($store->store_type == 'D') Depósito @else Local @endif :: {{ str_pad($store->cod_fenovo, 3, '0', STR_PAD_LEFT)  }} - {{ $store->description }}
        </p>
    </div>
</div>
<div class="table-responsive">
    <table class=" table table-hover dataTable table-condensed yajra-datatable" role="grid">
        <thead class="text-body">
            <tr class="bg-dark text-black-50">
                <td>Codigo</td>
                <td class=" w-50">Producto</td>
                <td>Stock</td>
                <td class=" w-25">Proveedor</td>
                <td>Historial</td>
            </tr>
        </thead>
        <tbody>
            @if (isset($productos))
                @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->cod_fenovo }}</td>
                    <td>{{ $producto->producto }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->proveedor }}</td>
                    <td>
                        <a href="{{ route('product.historial.tienda', ['store_id' => $store->id,'product_id' => $producto->id]) }}">
                            <i class="fa fa-list" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>


<script>

    var dataTable = jQuery(".yajra-datatable").DataTable({
        scrollY: 300,
        paging: false,
        ordering: false,
        iDisplayLength: -1,
    });
</script>
