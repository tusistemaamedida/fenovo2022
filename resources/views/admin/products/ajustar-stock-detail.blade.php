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
            <h4 class=" card-title mb-0">Peso <span class=" text-danger"> {{ $product->unit_weight }} </span> </h4>
        </div>
        <div class="col-2 text-center">
            <h4 class=" card-title mb-0">Unidad medida <span class=" text-danger"> {{ $product->unit_type }} </span>
            </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <table style="width: 100%; font-size: 1.2em;  height: 50px;">
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
            <input type="hidden" name="bultos" id="bultos">

            <table style="width: 100%; font-size: 1.2em;  height: 50px;">
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
                            <h4>{{ $stock_presentaciones[$i]['presentacion'] }}</h4>
                        </th>
                        <td class="text-center">
                            <input type="text" name="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                id="unidades_{{ $stock_presentaciones[$i]['presentacion'] }}"
                                class="form-control calculate text-center bg-white border-danger" value="0"
                                onkeyup="sumar(this)">
                        </td>
                    </tr>
                @endfor
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr>
                    <th>
                        AJUSTAR
                    </th>
                    <th class=" text-center">
                        <a href="javascript:ajustar()" id="btnAplicar" class="btn btn-block btn-danger"
                            title="Ajustar stock ">
                            <i class="fas fa-wrench text-white"></i>
                        </a>
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr>
                    <td>OPERACION </td>
                    <th>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="operacion" checked value="suma">
                                SUMAR
                            </label>
                        </div>
                    
                        <div class="form-check form-check-inline text-right">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="operacion" value="resta">
                                RESTAR
                            </label>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr>
                    <td>TIPO</td>
                    <th>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="tipo" checked value="F">
                                FACTURADO
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="tipo" value="R">
                                REMITO
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="tipo" value="CyO">
                                CTAyORDEN
                            </label>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr>
                    <td>OBSERVACIONES</td>
                    <th>
                        <input type="text" name="observacion" id="observacion" class="form-control">
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><br></td>
                </tr>
                <tr class=" bg-light">
                    <th>
                        CANTIDAD AJUSTAR
                    </th>
                    <th class=" text-center">
                        <input type="hidden" name="cantidad" id="cantidad">
                        <h4> <span id="txtCantidad" class="text-danger"> 0 </span> {{ $product->unit_type }} </h4>
                    </th>
                </tr>

            </table>
        </div>
    </div>
</form>
