<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($permission)?'Editar':'Agregar'}} permiso
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="name" name="name" @if (isset($permission)) value="{{$permission->name}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group d-none">
    <label class="text-dark">Guard Name</label>
    <input type="text" id="guard_name" name="guard_name" @if (isset($permission)) value="{{$permission->guard_name}}" @else value="web" @endif class="form-control">
</div>

<div class="form-group">
    <label class="text-dark">Rol</label>
    <fieldset class="form-group">
        <select class="rounded form-control bg-transparent" name="rol_id" id="rol_id">
            @forelse ($roles as $rol)
            <option value="{{$rol->id}}" @if(isset($permission) && isset($permission->roles->pluck('id')[0]) && ($rol->id == $permission->roles->pluck('id')[0]) ) selected @endif>
                {{$rol->name}}
            </option>
            @empty
            <option value="">No hay roles</option>
            @endforelse
        </select>
    </fieldset>

</div>

@if (isset($permission))
<div class="row" style="margin-bottom: 25px">
    <div class="col-4">
        <fieldset>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" @if (isset($permission) && $permission->active) checked="" @endif name="active" id="active" value='1'>
                <label class="custom-control-label" for="active">Activo</label>
            </div>
        </fieldset>
    </div>
</div>

<input type="hidden" name="permission_id" value="{{$permission->id}}" />
@endif