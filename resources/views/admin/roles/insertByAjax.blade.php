<div class="form-group">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">
        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal">
            {{ ($role)?'Editar':'Agregar'}} Rol
        </h4>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Nombre</label>
    <input type="text" id="name" name="name" @if (isset($role)) value="{{$role->name}}" @else value="" @endif class="form-control" required>
</div>

@if (isset($role))
<div class="row" style="margin-bottom: 25px">
    <div class="col-4">
        <fieldset>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" @if (isset($role) && $role->active) checked="" @endif name="active" id="active" value='1'>
                <label class="custom-control-label" for="active">Activo</label>
            </div>
        </fieldset>
    </div>
</div>

<input type="hidden" name="role_id" value="{{$role->id}}" />
@endif