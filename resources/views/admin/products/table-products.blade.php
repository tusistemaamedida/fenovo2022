<table id="productTable" class="table table-condensed table-hover yajra-datatable">
    <thead>
        <tr class="bg-dark text-white">
            <th>Codigo</th>
            <th>Producto</th>
            <th>Stock</th>
            <th>Tipo senasa</th>
            <th>Proveedor</th>
            @can('products.create')
            <th></th>
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>