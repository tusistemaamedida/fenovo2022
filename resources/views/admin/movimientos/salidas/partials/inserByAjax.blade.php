<h4>{{$product->name}}</h4>
<br>
<div class="form-group">

        <div class="row text-center">
            <div class="col-12 bg-dark text-white">Kgrs</div>
        </div>
        <div class="row text-center">
            <div class="col-6">Stock</div>
            <div class="col-6">Envío</div>
        </div>
        <div class="row text-center font-size-bold ">
            <div class="col-6">
                <h4>{{$stock_total}}</h4>
            </div>
            <div class="col-6">
                <h4> <span id="envio_total" class=" text-danger">0</span> </h4>
            </div>
        </div>


    <input type="hidden" name="tope" id="tope" value="{{$stock_total}}">
    <input type="hidden" name="kg_totales" id="kg_totales" value="0">
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

                    @if($i == 0) <input type="hidden" id="input_focus" value="unidades_{{$stock_presentaciones[$i]['presentacion']}}"> @endif

                    <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                    <td class="text-center">
                        <input type="text"
                                name="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                                id="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                                class="form-control calculate text-center"
                               {{-- @if($stock_total==0) disabled @endif --}}
                                max="{{$stock_presentaciones[$i]['bultos']}}"
                                value="0"
                                onkeyup="sumar(this,event)" >
                    </td>
                    </tr>
                    @endfor
            </tbody>
        </table>
    </form>
    <br>
</div>

<script>
    var input = jQuery("#input_focus").val();
    document.getElementById(input).focus();
    document.getElementById(input).select();
</script>
