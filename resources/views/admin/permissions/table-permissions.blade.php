<table id="permissionTable" class="display">
    <thead class="text-body">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Role</th>
            <th class="no-sort"></th>
        </tr>
    </thead>
    <tbody class="kt-table-tbody text-dark">
        @if (isset($permissions))
        @foreach ($permissions as $permission)
        <tr class="kt-table-row kt-table-row-level-0">
            <td>{{$permission->id}}</td>
            <td>{{$permission->name}}</td>
            <td>{{$permission->description}}</td>
            <td>{{ $permission->role->name }}</td>
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
                        <a class="dropdown-item" href="{{ route('permissions.edit', $permission->id) }}">Editar</a>
                        <a class="dropdown-item confirm-delete" title="Delete" href="#">Borrar</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>