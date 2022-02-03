<div class="form-group row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <label  class="text-body">Nombre *</label>
                <fieldset class="form-group mb-3">
                    <input type="text" name="name" id="name" value="" class="form-control border-dark" >
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Categoría *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="categorie_id" id="categorie_id">
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Rubro</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="type_id" id="type_id">
                        @foreach ($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Código Fenovo *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" name="cod_fenovo" id="cod_fenovo" value="" class="form-control border-dark" onfocusout="validateCode()" >
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Código de barras</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" name="barcode" id="barcode">
                </fieldset>
            </div>

            <div class="col-md-12 mb-3">
                <label  class="text-body">Descripción pública (web)</label>
                <textarea type="text" name="description" rows="8" id="txtarea" class="autoexpand-textarea form-control"></textarea>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Cuenta contable entrada</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" name="cod_cuenta_compra" id="cod_cuenta_compra">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Cuenta contable salida</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" name="cod_cuenta_venta" id="cod_cuenta_venta">
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-6">
                <label  class="text-body">Proveedor *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="proveedor_id" id="proveedor_id">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{$proveedor->name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label  class="text-body">Código producto proveedor</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" name="cod_proveedor" id="cod_proveedor">
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Unidad de medida *</label>
                <select class="js-example-basic-single js-states form-control bg-transparent" name="unit_type" id="unit_type">
                    <option value="K">Pesable</option>
                    <option value="U">Unidad</option>
                </select>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Peso por unidad *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="text" class="form-control border-dark" name="unit_weight" id="unit_weight">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Kg.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Unidad x bulto *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="unit_package" id="unit_package" multiple="multiple" >
                        @for ($i = 1; $i < 101; $i++)
                            <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Peso bulto neto *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="net_weight" id="net_weight">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Kg.</span>
                    </div>
                </fieldset>
            </div>


            <div class="col-md-3">
                <label  class="text-body">Stock sem. min *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="stock_sem_min" id="stock_sem_min">
                </fieldset>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Stock sem. max. *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="stock_sem_max" id="stock_sem_max">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Stock mínimo en freezer. *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="stock_min" id="stock_min">
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Alto</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="hight" id="hight">
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Ancho</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="width" id="width">
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label  class="text-body">Largo</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="long" id="long">
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Bultos x pallet</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="package_palet" id="package_palet">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Bultos x fila</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="package_row">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Fragilidad *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="fragility" id="fragility" >
                        <option value="1">Baja</option>
                        <option value="2">Media</option>
                        <option value="3">Alta</option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label  class="text-body">Moneda *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="currency" id="currency" >
                        <option value="1">Peso Argentino</option>
                        <option value="2">Real</option>
                        <option value="3">Dolar</option>
                    </select>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group row">
            <div class="col-md-3">
                <div class="switch-h d-flex mb-3">
                    <label style="margin-right: 5px">Ventas online?</label>
                    <div class="custom-control switch custom-switch custom-control-inline mr-0">
                        <input type="checkbox" class="custom-control-input" id="online_sale" name="online_sale" checked="" value="1">
                        <label class="custom-control-label mr-1" for="online_sale"></label>
                        </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="switch-h d-flex mb-3">
                    <label style="margin-right: 5px">Activo?</label>
                    <div class="custom-control switch custom-switch custom-control-inline mr-0">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" checked="" value="1">
                        <label class="custom-control-label mr-1" for="active"></label>
                        </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="switch-h d-flex mb-3">
                    <label style="margin-right: 5px">SENASA?</label>
                    <div class="custom-control switch custom-switch custom-control-inline mr-0">
                        <input type="checkbox" class="custom-control-input" id="is_senasa" name="is_senasa" value="1">
                        <label class="custom-control-label mr-1" for="is_senasa"></label>
                        </div>
                </div>
            </div>

            <div class="col-md-3">
                <label  class="text-body">Agrupación</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="senasa_id" >
                        <option value="">Seleccione una opción</option>
                        @foreach ($senasaDefinitions as $senasaDefinition)
                            <option value="{{$senasaDefinition->id}}">{{$senasaDefinition->product_name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
        </div>
    </div>

</div>
