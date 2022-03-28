@if (isset($product))
<div class="form-group row">
    <div class="col-md-9 font-size-h5">
        <span id="divFechasPrecio">
            <a href="{{route('product.edit',['id' => $product->id])}}#precios" @if(isset($fecha_actualizacion_activa) && $fecha_actualizacion_activa !=0) onclick="jQuery('#loader').removeClass('hidden')" @endif>
                <span class="badge @if ( Request::get('fecha_oferta') == null AND Request::get('fecha_actualizacion_activa') == null) badge-secondary @else badge-light @endif p-2">
                    Precio actual
                </span>
            </a>
            @foreach ($product->session_prices as $p)
            <a href="{{route('product.edit',['id' => $product->id,'fecha_actualizacion_activa' => $p->id])}}#precios" @if(isset($fecha_actualizacion_activa) && $p->id != $fecha_actualizacion_activa) onclick="jQuery('#loader').removeClass('hidden')" @endif>
                <span class="badge
                @if(isset($fecha_actualizacion_activa) && $p->id != $fecha_actualizacion_activa)
                    badge-light
                @else
                    badge-primary
                @endif p-2">
                    Actualización :: {{\Carbon\Carbon::parse($p->fecha_actualizacion)->format('d/m/Y')}}
                </span>
            </a>
            @endforeach
        </span>

        @foreach ($ofertas as $precio_oferta)
        <a href="{{route('product.edit',['id' => $product->id, 'oferta_id' => $precio_oferta->id,'fecha_oferta' => $precio_oferta->fecha_desde ])}}#precios" onclick="jQuery('#loader').removeClass('hidden')">
            <span class="badge @if(Request::get('fecha_oferta') !== null && Request::get('oferta_id') == $precio_oferta->id) badge-primary @else badge-light @endif p-2">
                Oferta :: {{\Carbon\Carbon::parse($precio_oferta->fecha_desde)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($precio_oferta->fecha_hasta)->format('d/m/Y')}}
            </span>
        </a>
        @endforeach

    </div>

    <div class="col-md-3 text-right">
        Estás editando
        <span class="text-primary font-size-h5">
            @if ( Request::get('fecha_oferta') == null AND Request::get('fecha_actualizacion_activa') == null)
                <strong> precio actual </strong>
                @php
                    $color = '#f49d2a';
                @endphp
            @else
                @php
                    $color = '#ae69f5';
                @endphp
            @if(Request::get('fecha_actualizacion_activa') !== null)
                actualización <strong> {{\Carbon\Carbon::parse($fecha_actualizacion)->format('d/m/Y')}} </strong>

            @else
            @if(Request::get('fecha_oferta') !== null)
                oferta desde el <strong> {{\Carbon\Carbon::parse($oferta->fecha_desde)->format('d/m/Y')}} </strong>
            @endif
            @endif
            @endif
        </span>
    </div>
</div>
@endif


<div class="form-group row" style="background-color: {{$color}}">
    <div class="col-md-5">
        <div class="form-group row">
            <div class="col-md-12">
                <label class="text-body">Precio proveedor</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->plistproveedor}}" @else value="" @endif name="plistproveedor" id="plistproveedor" class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plistproveedor}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Desc. Proveedor</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->descproveedor}}" @else value="0" @endif name="descproveedor" id="descproveedor" class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-8">
                <label class="text-body">Costo</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->costfenovo}}" @else value="0" @endif name="costfenovo" id="costfenovo" disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->costfenovo}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-12">
                <hr />
            </div>

            <div class="col-md-4">
                <label class="text-body">Markup Fenovo</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->mupfenovo}}" @else value="16" @endif name="mupfenovo" id="mupfenovo" class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Fondo contribución</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" @if (isset($product)) value="{{$product->product_price->contribution_fund}}" @else value="0" @endif name="contribution_fund" id="contribution_fund" class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Lista 0 neto</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" @if (isset($product)) value="{{$product->product_price->plist0neto}}" @else value="0" @endif min="0" name="plist0neto" id="plist0neto" disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plist0neto}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Lista 0 neto + Iva</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" @if (isset($product)) value="{{$product->product_price->plist0iva}}" @else value="0" @endif min="0" name="plist0iva" id="plist0iva" disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->plist0iva}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-6">
                <label class="text-body">Descuento</label>
                <fieldset class="form-group mb-3">
                    <select class="form-control" disabled>
                        @foreach ($descuentos as $descuento)
                            <option value="" @if (isset($product) && $product->cod_descuento == $descuento->codigo) selected @endif>
                                {{$descuento->descripcion}}
                            </option>
                        @endforeach
                    </select>
                </fieldset>
            </div>

            <div class="col-md-12">
                <p><small id="info-calculate" style="margin-top: 0;font-size:13px;top: 30px;color:rgb(217 13 47)"></small></p>
            </div>
            <div class="row mb-1">
                &nbsp;
            </div>

            @if(isset($product))

            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-12">
                        @if(isset($fecha_actualizacion_activa) && $fecha_actualizacion_activa !=0)
                        <span class=" badge badge-secondary p-2 font-size-h5"> Fecha de <span class=" font-weight-bolder"> actualización </span> </span>
                        @else
                        Fecha de <span class=" font-weight-bolder"> actualización </span>
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="date" id="fecha_actualizacion" name="fecha_actualizacion" class="form-control" @if(isset($fecha_actualizacion_activa) && $fecha_actualizacion_activa !=0) value="{{$fecha_actualizacion}}" @endif>
                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-5">
                    </div>
                </div>
            </div>

            <div id="divOferta" class="col-md-12 mt-2">
                <div class="row">
                    <div class="col-md-12">
                        @if(Request::get('fecha_oferta') !== null)
                        <span class=" badge badge-secondary p-2 font-size-h5">
                            Fecha de <span class=" font-weight-bolder">oferta </span>
                        </span>
                        @else
                        Fecha de <span class=" font-weight-bolder">oferta </span>
                        @endif
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-5">
                        <input type="date" id="fecha_desde" name="fecha_desde" @if(Request::get('fecha_oferta') !==null) value="{{ $oferta->fecha_desde}}" @else value="" @endif class="form-control">
                    </div>
                    <div class="col-md-5">
                        <input type="date" id="fecha_hasta" name="fecha_hasta" @if(Request::get('fecha_oferta') !==null) value="{{ $oferta->fecha_hasta}}" @else value="" @endif class="form-control">
                    </div>
                    <div class="col-md-1 mt-2">

                    </div>
                    <div class="col-md-1 mt-2">

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="col-md-7">
        <div class="form-group row">
            <div class="col-md-4">
                <label class="text-body">Markup lista 1</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="muplist1" id="muplist1" @if (isset($product)) value="{{$product->product_price->muplist1}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-4">
                <label class="text-body">Precio lista 1</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="plist1" id="plist1" @if (isset($product)) value="{{$product->product_price->plist1}}" @else value="0" @endif disabled class="form-control border-dark">
                </fieldset>
            </div>
            <div class="col-md-4">
                <label class="text-body">Comision lista 1</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="comlista1" id="comlista1" @if (isset($product)) value="{{$product->product_price->comlista1}}" @else value="0" @endif disabled class="form-control border-dark">
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Markup lista 2</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="muplist2" id="muplist2" @if (isset($product)) value="{{$product->product_price->muplist2}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-4">
                <label class="text-body">Precio lista 2</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="plist2" id="plist2" @if (isset($product)) value="{{$product->product_price->plist2}}" @else value="0" @endif disabled class="form-control border-dark">
                </fieldset>
            </div>
            <div class="col-md-4">
                <label class="text-body">Comision lista 2</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="comlista2" id="comlista2" @if (isset($product)) value="{{$product->product_price->comlista2}}" @else value="0" @endif disabled class="form-control border-dark">
                </fieldset>
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-md-6">
                <label class="text-body">Precio tienda 1</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="p1tienda" id="p1tienda" @if (isset($product)) value="{{$product->product_price->p1tienda}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p1tienda}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label class="text-body">Markup precio tienda 1</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mup1" id="mup1" @if (isset($product)) value="{{$product->product_price->mup1}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mup1}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Cant. mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="cantmay1" id="cantmay1" @if (isset($product)) value="{{$product->product_price->cantmay1}}" @else value="0" @endif class="form-control border-dark">
                </fieldset>
            </div>

            <div class="col-md-3">
                <label class="text-body">Desc. mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="descp1" id="descp1" @if (isset($product)) value="{{$product->product_price->descp1}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Precio 1 mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="p1may" id="p1may" @if (isset($product)) value="{{$product->product_price->p1may}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p1may}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Markup</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mupp1may" id="mupp1may" @if (isset($product)) value="{{$product->product_price->mupp1may}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mupp1may}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
        </div>
        <hr>

        <div class="form-group row">
            <div class="col-md-6">
                <label class="text-body">Precio tienda 2</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="p2tienda" id="p2tienda" @if (isset($product)) value="{{$product->product_price->p2tienda}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p2tienda}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-6">
                <label class="text-body">Markup precio tienda 2</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mup2" id="mup2" @if (isset($product)) value="{{$product->product_price->mup2}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mup2}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Cant. mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="cantmay2" @if (isset($product)) value="{{$product->product_price->cantmay2}}" @else value="0" @endif class="form-control border-dark">
                </fieldset>
            </div>

            <div class="col-md-3">
                <label class="text-body">Desc. mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="descp2" id="descp2" readonly @if (isset($product)) value="{{$product->product_price->descp2}}" @else value="0" @endif class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">%</span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Precio 2 mayorista</label>
                <fieldset class="input-group form-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" step="0.50" min="0" name="p2may" id="p2may" @if (isset($product)) value="{{$product->product_price->p2may}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->p2may}} @endif</b>
                        </span>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-3">
                <label class="text-body">Markup</label>
                <fieldset class="input-group form-group mb-3">
                    <input type="number" step="0.50" min="0" name="mupp2may" id="mupp2may" @if (isset($product)) value="{{$product->product_price->mupp2may}}" @else value="0" @endif disabled class="form-control border-dark">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <b style="color:blue; font-size:10px; float:right">@if (isset($product)){{$product->product_price->mupp2may}} @endif %</b>
                        </span>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
