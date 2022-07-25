<div class="table-responsive">
    <table class=" table table-hover dataTable table-condensed yajra-datatable" role="grid">
        <thead class="text-body">
            <tr class="bg-dark text-black-50">
                <td class=" w-30px">Codigo</td>
                <td class=" w-50">Producto</td>
                <td class=" w-30px">Stock</td>
                <td class=" w-30px">Proveedor</td>
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
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: 1 },
            { orderable: false, targets: 2 },
            { orderable: false, targets: 3 },
        ],
        order: [[1, 'asc']],
        iDisplayLength: -1,
    });

    
</script>