<div class="table-datapos">
    <div class="table-responsive">
        <table id="productTable" class=" table table-hover display dataTable no-footer yajra-datatable" role="grid">
            <thead class="text-body">
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
            <tbody class="kt-table-tbody text-dark">
            </tbody>
        </table>
    </div>
</div>