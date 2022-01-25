<div class="form-group">
    <div class="row">
        <div class="col-12">
            <h4 class="font-size-h4 font-weight-bold m-0">{{ ($movement)?'Editar':'Agregar'}} ingreso</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="card card-custom gutter-b bg-white border-0">
            <div class="card-body">
                <form>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <select class="rounded form-control bg-transparent" name="to">
                                    <option value="">No hay proveedor</option>
                                    @foreach ( as )

                                    @endforeach ($proveedores as $proveedor)
                                    <option value="{{$proveedor->id}}">
                                        {{$proveedor->name}}
                                    </option>
                                    @endforelse

                                    @foreach ($collection as $item)

                                    @endforeach
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>