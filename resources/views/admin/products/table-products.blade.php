<table id="productTable" class="display ">
    <thead class="text-body">
        <tr>
            <th>#</th>
            <th>Detalle</th>
            <th>Costo</th>
            <th>Precio Fenovos</th>
            <th>Tiendas</th>
            <th>Proveedor</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody class="kt-table-tbody text-dark">
        @if (isset($products))
            @foreach ($products as $product)
            <tr class="kt-table-row kt-table-row-level-0">
                <td >{{$product->cod_fenovo}}</td>
                <td >{{$product->name}}</td>
                <td >{{$product->product_price->costfenovo}}</td>
                <td >
                    L0: {{$product->product_price->plist0iva}}<br>
                    L1: {{$product->product_price->plist1}}<br>
                    L2: {{$product->product_price->plist2}}
                </td>
                <td >
                    PT1: {{$product->product_price->p1tienda}}<br>
                    PT2: {{$product->product_price->p2tienda}}<br>
                </td>
                <td >{{$product->proveedor->name}}</td>

                <td>
                    <div class="card-toolbar text-right">
                        <button class="btn p-0 shadow-none" type="button" id="dropdowneditButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="svg-icon">
                                <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                                </svg>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton" >
                            <a class="dropdown-item" href="add-product.html">Edit</a>
                            <a class="dropdown-item confirm-delete" title="Delete" href="#">Delete</a>
                        </div>
                    </div>
                </td>

            </tr>
            @endforeach
        @endif
    </tbody>
</table>
