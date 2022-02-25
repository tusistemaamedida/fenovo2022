<div class="form-group">
    <label class="text-dark">Username</label>
    <input type="text" name="username" @if (isset($user)) value="{{$user->username}}" @else value="" @endif class="form-control" required>
</div>


<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Password</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="col-6">
            <label class="text-dark">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" class="form-control">
        </div>
    </div>
</div>

<div class="form-group">
    <label class="text-dark">Email</label>
    <input type="email" id="email" name="email" @if (isset($user)) value="{{$user->email}}" @else value="" @endif class="form-control" required>
</div>

<div class="form-group">
    <label class="text-dark">Nombre y apellido</label>
    <input type="text" id="name" name="name" @if (isset($user)) value="{{$user->name}}" @else value="" @endif class="form-control" required>
</div>
<hr />
<div class="form-group">
    <div class="row">
        <div class="col-6">
            <label class="text-dark">Rol</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="rol_id">
                    @forelse ($roles as $rol)
                    <option value="{{$rol->id}}" @if(isset($user) && isset($user->roles->pluck('id')[0]) && ($rol->id == $user->roles->pluck('id')[0]) ) selected @endif>
                        {{$rol->name}}
                    </option>
                    @empty
                    <option value="">No hay roles</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
        <div class="col-6">
            <label class="text-dark">Tienda asociada</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="store_active">
                    <option value="">Seleccione ...</option>
                    @foreach ($stores as $store)
                    <option value="{{$store->id}}" @if(isset($user) && ($user->store_active == $store->id)) selected @endif>
                        {{$store->description}}
                    </option>
                    @endforeach
                </select>
            </fieldset>
        </div>
    </div>
</div>


<div class="form-group">
    @if (isset($user))

    <div class="row">
        <div class="col-4">
            <fieldset>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" @if (isset($user) && $user->active) checked="" @endif name="active" id="active" value='1'>
                    <label class="custom-control-label" for="active">Activo</label>
                </div>
            </fieldset>
        </div>
    </div>

    <input type="hidden" name="user_id" value="{{$user->id}}" />

    @endif
</div>