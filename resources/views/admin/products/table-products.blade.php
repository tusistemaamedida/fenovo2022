<div class="table-datapos">
    <div class="table-responsive">
        <table id="productTable" class=" table table-hover display dataTable no-footer yajra-datatable" role="grid">
            <thead class="text-body">
                <tr class="bg-dark text-white">
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Stock</th>
                    <th>Costo</th>
                    <th>Proveedor</th>
                    @can('products.create')
                    <th>Ajust Stock</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                    @endcan
                </tr>
            </thead>
            <tbody class="kt-table-tbody text-dark">
            </tbody>
        </table>
    </div>
</div>
