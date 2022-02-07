<h4>{{$product->name}}</h4>
<br>
<div class="form-group">
    <label class="text-dark">Saldo Actual</label>
    <form name="unidades_a_enviar" id="unidades_a_enviar">
        <table class="table table-striped  text-body">
            <thead>
                <tr class="">
                    <th class="border-0  header-heading" scope="col">Pres.</th>
                    <th class="border-0  header-heading" scope="col">Kg</th>
                    <th class="border-0  header-heading" scope="col">Bultos</th>
                    <th class="border-0  header-heading" scope="col">Enviar</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($stock_presentaciones); $i++)
                    <tr>
                        <td>{{$stock_presentaciones[$i]['presentacion']}}</td>
                        <td>{{$stock_presentaciones[$i]['stock']}}</td>
                        <td>{{$stock_presentaciones[$i]['bultos']}}</td>
                        <td>
                            <input type="number"
                                name="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                                id="unidades_{{$stock_presentaciones[$i]['presentacion']}}"
                                class="form-control"
                                @if($stock_presentaciones[$i]['stock'] == 0) disabled @endif
                                max="{{$stock_presentaciones[$i]['bultos']}}"
                                value="0"
                                onkeyup="verif({{$stock_presentaciones[$i]['presentacion']}})">
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </form>
    <br>
</div>
<br>


