<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="name" name="name" @if (isset($permission)) value="{{$permission->name}}" @else value="" @endif class="form-control" required autofocus>
</div>

<div class="form-group">
    <label class="text-dark">Rol</label>
    <fieldset class="form-group">
        <select class="rounded form-control bg-transparent" name="rol_id" id="rol_id">
            @forelse ($roles as $rol)
            <option value="{{$rol->id}}" @if($rol->id == $permission->rol_id) selected @endif>
                {{$rol->name}}
            </option>
            @empty
            <option value="">No hay roles</option>
            @endforelse
        </select>
    </fieldset>

</div>

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



@if (isset($permission))
<input type="hidden" name="permission_id" value="{{$permission->id}}" />
@endif