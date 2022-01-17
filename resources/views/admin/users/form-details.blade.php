<form id="formUser">
    @csrf

    <div class="form-group row">
        <div class="col-4">
            <label class="text-dark">Username</label>
            <input type="text" name="username" class="form-control" autofocus>
        </div>
        <div class="col-4">
            <label class="text-dark">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="col-4">
            <label class="text-dark">Password</label>
            <input type="text" name="password" value="" class="form-control" autocomplete="off">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-12">
            <label class="text-dark">Nombre y apellido del usuario</label>
            <input type="text" id="name" name="name" class="form-control">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <label class="text-dark">Rol</label>
            <fieldset class="form-group">
                <select class="rounded form-control bg-transparent" name="rol_id">
                    @forelse ($roles as $rol)
                    <option value="{{$rol->id}}">
                        {{$rol->name}}
                    </option>
                    @empty
                    <option value="">No hay roles</option>
                    @endforelse
                </select>
            </fieldset>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-4">
            <button type="button" class="btn btn-primary" id="btn-guardar-user"><i class="fa fa-save"></i> Guardar</button>
        </div>
    </div>

</form>