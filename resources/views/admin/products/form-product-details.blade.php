<div class="form-group row">
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-12">
                <label class="text-body">Nombre *</label>
                <fieldset class="form-group mb-3">
                    <input type="text" name="name" id="name" @if (isset($product)) value="{{$product->name}}" @else value="" @endif class="form-control border-dark">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Categoría *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="categorie_id" id="categorie_id">
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}" @if (isset($product) && $product->categorie_id == $category->id) selected @endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Descuento</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="cod_descuento" id="cod_descuento">
                        <option value="">Seleccione un descuento </option>
                        @foreach ($descuentos as $descuento)
                        <option value="{{$descuento->codigo }}" @if (isset($product) && $product->cod_descuento == $descuento->codigo) selected @endif>
                            {{$descuento->descripcion}}
                        </option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Código Fenovo *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" name="cod_fenovo" id="cod_fenovo" @if (isset($product)) value="{{$product->cod_fenovo}}" @else value="" @endif class="form-control border-dark" onfocusout="validateCode()">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Código de barras</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" @if (isset($product)) value="{{$product->barcode}}" @else value="" @endif name="barcode" id="barcode">
                </fieldset>
            </div>

            <div class="col-md-12 mb-3">
                <label class="text-body">Descripción pública (web)</label>
                <textarea type="text" name="description" rows="4" id="txtarea" class="autoexpand-textarea form-control" @if (isset($product)) value="{{$product->description}}" @else value="" @endif>@if (isset($product)){{$product->description}} @endif</textarea>
            </div>

            <div class="col-md-6">
                <label class="text-body">Cuenta contable entrada</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" @if (isset($product)) value="{{$product->cod_cuenta_compra}}" @else value="" @endif name="cod_cuenta_compra" id="cod_cuenta_compra">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Cuenta contable salida</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" @if (isset($product)) value="{{$product->cod_cuenta_venta}}" @else value="" @endif name="cod_cuenta_venta" id="cod_cuenta_venta">
                </fieldset>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-md-6">
                <label class="text-body">Proveedor *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="proveedor_id" id="proveedor_id">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                        <option value="{{$proveedor->id}}" @if (isset($product) && $product->proveedor_id == $proveedor->id) selected @endif>{{$proveedor->name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label class="text-body">Código producto proveedor</label>
                <fieldset class="form-group mb-3">
                    <input type="text" class="form-control border-dark" @if (isset($product)) value="{{$product->cod_proveedor}}" @else value="" @endif name="cod_proveedor" id="cod_proveedor">
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Unidad de medida *</label>
                <select class="js-example-basic-single js-states form-control bg-transparent" name="unit_type" id="unit_type">
                    <option value="K" @if (isset($product) && $product->unit_type == 'K') selected @endif>Pesable</option>
                    <option value="U" @if (isset($product) && $product->unit_type == 'U') selected @endif>Unidad</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="text-body">Peso por unidad *</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="text" class="form-control border-dark" @if (isset($product)) value="{{$product->unit_weight}}" @else value="" @endif name="unit_weight" id="unit_weight">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Kg.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Unidad x bulto *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="unit_package[]" id="unit_package" multiple="multiple">

                        @for ($i = 1; $i < 101; $i +=0.5) <option value="{{$i}}">
                            {{$i}}
                            </option>
                            @endfor

                            @if(isset($product))
                            @foreach ( $unit_package as $unit )
                            <option value="{{$unit}}" selected>
                                {{$unit}}
                            </option>
                            @endforeach
                            @endif


                    </select>
                </fieldset>
            </div>

            <div class="col-md-3">
                <label class="text-body">Stock sem. min *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" @if (isset($product)) value="{{$product->stock_sem_min}}" @else value="2" @endif name="stock_sem_min" id="stock_sem_min">
                </fieldset>
            </div>

            <div class="col-md-3">
                <label class="text-body">Stock sem. max. *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" @if (isset($product)) value="{{$product->stock_sem_max}}" @else value="2" @endif name="stock_sem_max" id="stock_sem_max">
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Stock mínimo en freezer. *</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" @if (isset($product)) value="{{$product->stock_min}}" @else value="100" @endif name="stock_min" id="stock_min">
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Alto</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="hight" id="hight" @if (isset($product)) value="{{$product->hight}}" @else value="" @endif>
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Ancho</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="width" id="width" @if (isset($product)) value="{{$product->width}}" @else value="" @endif>
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Largo</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" class="form-control border-dark" name="long" id="long" @if (isset($product)) value="{{$product->long}}" @else value="" @endif>
                    <div class="input-group-prepend">
                        <span class="input-group-text">mt.</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Bultos x pallet</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="package_palet" id="package_palet" @if (isset($product)) value="{{$product->package_palet}}" @else value="" @endif>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Bultos x fila</label>
                <fieldset class="form-group mb-3">
                    <input type="number" class="form-control border-dark" name="package_row" @if (isset($product)) value="{{$product->package_row}}" @else value="" @endif>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Fragilidad *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="fragility" id="fragility">
                        <option value="1" @if (isset($product) && $product->fragility == '1') selected @endif>Baja</option>
                        <option value="2" @if (isset($product) && $product->fragility == '2') selected @endif>Media</option>
                        <option value="3" @if (isset($product) && $product->fragility == '3') selected @endif>Alta</option>
                    </select>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Moneda *</label>
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="currency" id="currency">
                        <option value="$" @if (isset($product) && $product->currency == '$') selected @endif>Peso Argentino</option>
                        <option value="R$" @if (isset($product) && $product->currency == 'R$') selected @endif>Real</option>
                        <option value="USD" @if (isset($product) && $product->currency == 'USD') selected @endif>Dolar</option>
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
                        <input type="checkbox" class="custom-control-input" id="online_sale" name="online_sale" @if (isset($product) && $product->online_sale) checked="" @elseif((isset($product) && !$product->online_sale) ) unchecked="" @else checked="" @endif value="1">
                        <label class="custom-control-label mr-1" for="online_sale"></label>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="switch-h d-flex mb-3">
                    <label style="margin-right: 5px">Activo?</label>
                    <div class="custom-control switch custom-switch custom-control-inline mr-0">
                        <input type="checkbox" class="custom-control-input" id="active" name="active" @if (isset($product) && $product->active) checked="" @elseif(isset($product) && !$product->active)) unchecked="" @else checked="" @endif value="1">
                        <label class="custom-control-label mr-1" for="active"></label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <fieldset class="form-group mb-3">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="senasa_id">
                        <option value="">Agrupación SENASA</option>
                        @foreach ($senasaDefinitions as $senasaDefinition)
                        <option value="{{$senasaDefinition->id}}" @if (isset($product) && $product->senasa_id == $senasaDefinition->id) selected @endif
                            >{{$senasaDefinition->product_name}}</option>
                        @endforeach
                    </select>
                </fieldset>
            </div>
        </div>
    </div>

</div>
