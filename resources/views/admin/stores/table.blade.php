<table id="storeTable" class="display">
    <thead class="text-body">
        <tr>
            <th>Cod Fenovo</th>
            <th>Nombre</th>
            <th>Cuit</th>
            <th>Region</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody class="kt-table-tbody text-dark">
        @if (isset($stores))
        @foreach ($stores as $store)
        <tr class="kt-table-row kt-table-row-level-0">
            <td>{{$store->cod_fenovo}}</td>
            <td>{{$store->fantasy_name}}</td>
            <td>{{ $store->cuit }}</td>
            <td>{{ $store->region->name }}</td>
            <td>
                <div class="card-toolbar text-right">
                    <button class="btn p-0 shadow-none" type="button" id="dropdowneditButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon">
                            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                            </svg>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton">
                        <a class="dropdown-item" href="{{ route('stores.edit', ['id'=>$store->id]) }}"> <i class="fa fa-edit"></i> Editar</a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <form method="post" action="{{ route('stores.destroy', $store) }}" id="formDelete">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn ml-0 p-0 show_confirm" data-toggle="tooltip" title='Borrar'>
                                    <i class="fa fa-trash text-danger"></i> Borrar
                                </button>
                            </form>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>