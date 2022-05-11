<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
    <table style="width:100%;">
        <tr>
            <td>
                <span style="font-size: 14px;">
                    # {{$id_flete}}
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-size: 14px;">
                    Fecha: {{$fecha}}
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-size:14px;line-height: 18px;">
                    {{$destino->description}}  {{$destino->address}}
                </span>
            </td>
        </tr>
    </table>

    <table style="margin-top:5px;">

        @for ($i = 0; $i < count($array_productos); $i++)

            @php
                $p = $array_productos[$i]
            @endphp

            <tr>
                <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->cant}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 40%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->name}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->unit_price}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->subtotal}}</span></th>
            </tr>

        @endfor
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>

            <tr >
                <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span >&nbsp;</span></th>
                <th style="font-size:12px;font-weight:500;width: 15%;text-align:left"><span >&nbsp;</span></th>
                <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span >Total: </span></th>
                <th style="font-size:12px;font-weight:0; width: 40%;text-align:left"><span >$ {{$neto}}</span></th>
            </tr>


    </table>
</body>

<html>
