<form method="POST" id="ajuste-stock">
    <div class="row mb-3">
        <div class="col-6">
            <h4 class=" card-title mb-0">
                {{ $product->cod_fenovo }} <span class=" font-weight-bold text-danger"> {{ $product->name }} </span>
            </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Stock total <span class=" text-danger"> {{ $stock }} </span> </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Peso <span class=" text-danger"> {{ $product->unit_weight }} </span> Kgrs
            </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Unidad medida <span class=" text-danger"> {{ $product->unit_type }} </span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <table class="table">
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class=" bg-dark text-white">
                    <th class="w-50">TIPO</th>
                    <th class="w-50 text-center">STOCK ACTUAL</th>
                </tr>
                <tr>
                    <td>FACTURADO</td>
                    <th class="text-center">{{ $product->stock_f }}</th>
                </tr>
                <tr>
                    <td>REMITO</td>
                    <th class="text-center">{{ $product->stock_r }}</th>
                </tr>
                <tr>
                    <td>CTA y ORDEN</td>
                    <th class="text-center">{{ $product->stock_cyo }}</th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>#Id interno <span class=" font-weight-bold"> {{ $product->id }} </span> </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>

        <div class="col-xs-12 col-md-6">

            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
            <input type="hidden" name="unit_type" id="unit_type" value="{{ $product->unit_type }}">
            <input type="hidden" name="unit_weight" id="unit_weight" value="{{ $product->unit_weight }}">

            <input type="hidden" name="voucher" id="voucher" value="{{ $voucher }}">
            <input type="hidden" name="origen" id="origen" value="{{ $origen }}">

            <input type="hidden" name="bultos" id="bultos">

            <table class="table">
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class=" bg-dark text-white">
                    <th class="w-50">PRESENTACIONES</th>
                    <th class="w-50 text-center">BULTOS</th>
                </tr>
                @for ($i = 0; $i < count($stock_presentaciones); $i++)
                    @if ($i == 0)
                        <input type="hidden" name="presentacion" id="presentacion"
                            value="{{ $stock_presentaciones[$i]['presentacion'] }}">
                    @endif

                    <tr>
                        <th class="text-center">
                            {{ $stock_presentaciones[$i]['presentacion'] }}
                        </th>
                        <td class="text-center">
                            <input type="text" name="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                id="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                class="form-control calculate text-center bg-white border-danger shadow-sm"
                                value="0" onkeyup="sumar(this)">
                        </td>
                    </tr>
                @endfor

                <tr>
                    <td>Observaciones / comentarios del ajuste</td>
                    <th>
                        <input type="text" name="observacion" id="observacion" class="form-control border-danger bg-white">
                    </th>
                </tr>
                <tr>
                    <td>OPERACION </td>
                    <td>
                        <ul class=" list-unstyled">
                            <li>
                                <label class="form-check-label m-2">
                                    <input class="form-check-input"  onclick="VerOperacion(this.value)" type="radio" name="operacion" value="suma" checked>
                                    SUMA
                                </label>
                            </li>
                            <li>
                                <label class="form-check-label m-2">
                                    <input class="form-check-input"  onclick="VerOperacion(this.value)" type="radio" name="operacion" value="resta">
                                    RESTA
                                </label>
                            </li>
                        </ul>

                    </td>
                </tr>
                <tr>
                    <td>TIPO</td>
                    <td>
                        <ul class=" list-unstyled">
                            <li>
                                <label class="form-check-label m-2">
                                    <input class="form-check-input" type="radio" name="tipo" checked value="F"> FACTURA
                                </label>
                            </li>
                            <li>
                                <label class="form-check-label m-2">
                                    <input class="form-check-input" type="radio" name="tipo" value="R"> REMITO
                                </label>
                            </li>
                            <li>
                                <label class="form-check-label m-2">
                                    <input class="form-check-input" type="radio" name="tipo" value="CyO">
                                    CTAyOrden
                                </label>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>
                        <input type="hidden" name="cantidad" id="cantidad">
                        <h4> <span id="txtOperacion" class="text-danger"> </span> <span id="txtCantidad" class="font-weight-bolder"> 0 </span> {{ $product->unit_type }} </h4>
                    </th>
                    <th class=" text-center">
                        <a href="javascript:ajustar()" id="btnAplicar" class="btn btn-block btn-danger"
                            title="Ajustar stock "> Ajustar stock
                        </a>
                    </th>
                </tr>
            </table>
        </div>
    </div>
</form>
