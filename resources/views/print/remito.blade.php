<html>
<?php $subtotal_pagina = 0; ?>
@for ($pag = 0; $pag < $paginas; $pag++) <head>
    <meta charset="UTF-8">
    <title>REMITO</title>
    </head>
    <style>
        .no-visible {
            visibility: hidden;
        }
    </style>

    <body>
        <table style="width:100%;">
            <tr>
                <td colspan="2" style=" text-align: center;">

                </td>
            </tr>
            <tr>
                <td style="width:50%"></td>
                <td style="width:50%;height:280px">
                    <span style="font-size: 14px;">
                        Fecha: {{\Carbon\Carbon::parse(now())->format('d/m/y')}}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style=" text-align: center;">
                    {{ $mercaderia_en_transito }}
                </td>
            </tr>
        </table>

        <table style="width:100%;margin-bottom:30px">
            <tr>
                <td style="width: 15%; text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="width: 20%; text-align:left">
                    <span style="font-size:14px;line-height: 18px;">
                        {{$destino->razon_social}} <br>
                        {{$destino->address}}
                    </span>
                </td>

                <td style="width: 25%;text-align:left">
                    <span style="font-size:14px;line-height: 18px;">
                        CUIT: {{$destino->cuit}}<br>
                        {{$destino->city}}
                    </span>
                </td>
            </tr>
        </table>

        <table style="margin-top:5px;">

            @php
            $init = $pag * $total_lineas;
            $to = ($pag + 1)* $total_lineas;
            $subtotal = 0;
            @endphp

            @for ($i = $init; $i < $to; $i++) @php $p=$array_productos[$i] @endphp <tr>
                <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span class="{{$p->class}}">{{$p->cant}}</span></th>
                <th style="font-size:12px;font-weight:500;width: 15%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;#&nbsp;&nbsp;</span></th>
                <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span class="{{$p->class}}">{{$p->codigo}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 40%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->name}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->unity}}</span></th>
                <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span class="{{$p->class}}">&nbsp;&nbsp;{{$p->total_unit}}</span></th>
                </tr>

                @endfor

                @if($pag + 1 == $paginas)
                <tr>
                    <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span>&nbsp;</span></th>
                    <th style="font-size:12px;font-weight:500;width: 15%;text-align:left"><span>&nbsp;</span></th>
                    <th style="font-size:12px;font-weight:0;width: 15%;text-align:right"><span>NETO: </span></th>
                    <th style="font-size:12px;font-weight:0; width: 40%;text-align:left"><span>${{number_format($neto, 2, ',', '.')}}</span></th>
                    <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span>&nbsp;</th>
                    <th style="font-size:12px;font-weight:0; width: 10%;text-align:left"><span>&nbsp;</span></th>
                </tr>
                @endif

        </table>

        <table style="width:100%;">
            <tr>
                <td style="height:150px;text-align: center;">
                    <span style="font-size:12px;">Página {{$pag+1}}</span>
                </td>
            </tr>
        </table>
    </body>
    @endfor
    <html>