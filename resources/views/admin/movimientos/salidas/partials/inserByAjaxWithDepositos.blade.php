<h4>{{$product->name}}</h4>
<br>
<div class="form-group">

    <div class="row text-center">
        <div class="col-12 bg-dark text-white">
            Unidad ::{{$product->unit_type}}
        </div>
    </div>
    <div class="row text-center">
        @foreach ($producto_en_depositos as $producto_en_deposito)
            <div class="col-4" style="padding-top: 5px;font-weight: bold;">{{$producto_en_deposito->deposito->razon_social}}</div>
            <div class="col-4" style="padding-top: 5px;font-weight: bold;">{{$producto_en_deposito->stock_f + $producto_en_deposito->stock_r + $producto_en_deposito->stock_cyo}}</div>
            <div class="col-4" style="padding-top: 5px;font-weight: bold;">
                <input type="radio" name="deposito" class="form-group deposito" value="{{$producto_en_deposito->deposito->id}}" style="margin-top: 3px;">
            </div>
            <hr style="width: 100%">
        @endforeach

    </div>
    <input type="hidden" name="tope" id="tope" value="{{$stock_total}}">
    <input type="hidden" name="kg_totales" id="kg_totales" value="0">
    <input type="hidden" name="unit_type" id="unit_type" value="{{ $product->unit_type }}">
    <input type="hidden" name="unit_weight" value="{{(float)$stock_presentaciones[0]['unit_weight']}}" id="unit_weight">

    <div class="row">
        <div class="col-12 mt-3 mb-3">&nbsp;</div>
    </div>

    <form name="unidades_a_enviar" id="unidades_a_enviar" onsubmit=" return false;">
        <table class="table">
            <thead>
                <tr>
                    <th class="border-0  header-heading" scope="col">Presentación</th>
                    <th class="border-0  header-heading" scope="col">Enviar</th>
                </tr>
            </thead>
            <tbody id="in-box">
                @for ($i = 0; $i < count($stock_presentaciones); $i++) <tr>
                    @if($i == 0)
                    <input type="hidden" id="input_focus" value="unidades_{{$stock_presentaciones[$i]['presentacion']}}">
                    @endif

                    <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                    <td class="text-center">
                        <input type="text"
                               name="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                               id="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                               class="form-control calculate text-center"
                               max="{{$stock_presentaciones[$i]['bultos']}}"
                               value="0"
                               autocomplete="off"
                               onclick="this.select()"
                               onkeyup="sumar(this,event)">
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
    </form>
    <br>
</div>

<script>
    function focused(input){
        var input = jQuery("#input_focus").val();
        document.getElementById(input).focus();
        document.getElementById(input).select();
    }
    focused();
</script>
