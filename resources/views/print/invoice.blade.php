<html>
    <?php $subtotal_pagina = 0; ?>
    @for ($pag = 0; $pag < $paginas; $pag++)
        <head>
            <meta charset="UTF-8">
            <title>Factura</title>
        </head>

        <style>
            table {
            font-family: Helvetica, Sans-Serif;
            border-collapse: collapse;
            width: 100%;
            }

            /* TABLE HEADER */
            .table-header td,
            .table-header th {
            border: 1px solid #999797;
            padding: 8px;
            }

            .table-header tr th {
            border: 1px solid #999797;
            width: 5%;
            font-size: 25px;
            border: 1px solid;
            text-align: center;
            }

            .table-emisor {
            border-top: 1px solid #999797;
            }

            /* TABLE EMISOR */
            .table-emisor td,
            .table-emisor th {
            padding: 8px;
            }

            .table-emisor tr .emisor {
            width: 45%;
            font-size: 20px;
            border-left: 1px solid #999797;
            }

            .table-emisor tr .codigo {
            width: 10%;
            text-align: center;
            border: 1px solid #999797;

            }

            .table-emisor tr .codigo .valor {
            font-size: 28px;
            }

            .table-emisor tr .codigo .descripcion {
            font-size: 10px;
            }

            .table-emisor tr .factura {
            width: 45%;
            text-align: center;
            padding-left: 25px;
            font-size: 25px;
            border-right: 1px solid #999797;
            }

            /* TABLE DATA EMISOR */
            .table-data-emisor td,
            .table-data-emisor th {
            padding: 8px;
            }

            .table-data-emisor tr .emisor {
            width: 50%;
            border-right: 1px solid #999797;
            border-left: 1px solid #999797;
            border-bottom: 1px solid #999797;
            text-align: left;
            }

            .table-data-emisor tr .factura {
            width: 50%;
            text-align: left;
            border-right: 1px solid #999797;
            border-bottom: 1px solid #999797;
            padding-left: 25px;
            }

            /* TABLE PERIODO */
            .table-periodo td,
            .table-periodo th {
            padding: 8px;
            }

            .table-periodo tr {
            border-right: 1px solid #999797;
            border-left: 1px solid #999797;
            border-bottom: 1px solid #999797;
            }

            /* TABLE RECEPTOR */
            .table-receptor td,
            .table-receptor th {
            padding: 8px;
            }

            .table-receptor tr .documentos {
            width: 40%;
            border-top: 1px solid #999797;
            border-left: 1px solid #999797;
            border-bottom: 1px solid #999797;
            text-align: left;
            }

            .table-receptor tr .personales {
            width: 60%;
            text-align: right;
            border-top: 1px solid #999797;
            border-right: 1px solid #999797;
            border-bottom: 1px solid #999797;
            }

            /* TABLE PRODUCTOS */
            .table-productos .cabecera {
            background-color: #999797;
            }

            .table-productos td,
            .table-productos th {
            padding: 8px;
            border-left: 1px solid #999797;
            border-right: 1px solid #999797;
            }

            footer {
            bottom: 0;
            }

            footer .montos {
            border: 1px solid #999797;
            }

            footer .recibo {
            position: absolute;
            border-top: 1px solid #999797;
            }

            .table-productos tr td {
            height: 10px !important;
            padding: 4px !important;
            font-size: 12px;
            text-align: right;
            }
            .no-visible{
            visibility: hidden;
            }
        </style>

        <body>
            <div style="overflow:hidden;">
                <table class="table-emisor">
                    <tr>
                      <th class="emisor">
                        <img src="{{public_path('logo_fenovo.jpg')}}" width="65%">
                      </th>
                      <th class="codigo">
                        <span class="valor">{{ $voucherType->code }}</span><br> <!-- Tipo de factura -->
                        <span class="descripcion">COD. 0{{ $voucherType->afip_id }}</span>
                      </th>
                      <th class="factura">
                        <span style="font-size: 18px;">
                          {{$titulo}} <br>
                          N°: {{ $invoice->voucher_number }} <br>
                          Fecha: {{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/y H:i')}}
                          <!-- fecha de impresion -->
                        </span>
                      </th>
                    </tr>
                  </table>

                  <table class="table-data-emisor">
                    <tr>
                      <td class="emisor">
                        <span style="font-size:18px; font-weight: bold;line-height: 28px;">
                          FENOVO S.A.
                        </span><br>
                        <span style="font-size:12px;line-height: 28px;">
                          ROQUE SAENZ PEÑA 4984 (3100) PARANA
                        </span><br>
                        <span style="font-size:12px;">
                          Condición I.V.A.: Resp. Inscripto
                        </span>
                      </td>

                      <td class="factura">
                        <p style="margin: 0;padding:0"><span style="font-size:12px; ">C.U.I.T.:&nbsp;</span>
                        <span style="font-size:12px;float: right; text-align:right"> 30-70959940-9</span><br>
                          <span style="font-size:12px; ">Ingresos Brutos:</span>
                        <span style="font-size:12px;float: right; text-align:right"> 30-70959940-9</span><br>
                         <span style="font-size:12px; ">Inicio de Actividades:&nbsp;</span>
                        <span style="font-size:12px;float: right; text-align:right"> 19/04/2006</span></p>
                      </td>
                    </tr>
                  </table>

                  <table class="table-periodo">
                    <tr>
                      <td style="border-left: 1px solid #999797;border-bottom: 1px solid #999797;border-right: 1px solid #999797;">
                        <span style="font-size:13px; font-weight: bold;line-height: 18px;">Señores: </span>
                        <span style="font-size:13px;line-height: 18px;"> {{$invoice->client_name}} </span><br>
                        <span style="font-size:13px; font-weight: bold;line-height: 18px;">Dirección: </span>
                        <span style="font-size:13px;line-height: 18px;"> {{$invoice->client_address}} </span>
                      </td>
                    </tr>

                    <tr>
                      <td style="border-left: 1px solid #999797;border-bottom: 1px solid #999797;border-right: 1px solid #999797;">
                        <span style="font-size:13px; font-weight: bold;line-height: 18px;">Condición de venta: </span>
                        <span style="font-size:13px;line-height: 18px;"> Cuenta corriente </span>
                      </td>
                    </tr>
                  </table>

                  <table class="table-periodo">
                    <tr>
                      <td
                        style="border-left: 1px solid #999797;border-bottom: 1px solid #999797;border-right: 1px solid #999797; width: 50%;">
                        <span style="font-size:13px; font-weight: bold;line-height: 18px;">Condición de I.V.A.: </span>
                        <span style="font-size:13px;line-height: 18px;"> {{$invoice->client_iva_type}} </span>
                      </td>

                      <td style="border-left: 1px solid #999797;border-bottom: 1px solid #999797; width: 50%;border-right: 1px solid #999797;">
                        <span style="font-size:13px; font-weight: bold;line-height: 18px;">C.U.I.T.: </span>
                        <span style="font-size:13px;line-height: 18px;"> {{$invoice->client_cuit}} </span>
                      </td>
                    </tr>
                  </table>

                  <table class="table-productos" cellpadding="0px" cellspacing="0" style="margin-top:2px;border-bottom: 1px solid #999797;">
                    <tr class="cabecera">
                        <th style="font-size:12px;width: 20px;">Cant.</th>
                        <th style="font-size:12px; ">Producto / Servicio</th>
                        <th style="font-size:12px; width: 30px;">IVA</th>
                        <th style="font-size:12px; width: 70px; ">Precio Unit.</th>
                        <th style="font-size:12px; width: 70px; ">Importe</th>
                    </tr>

                    @php
                        $init = $pag * $total_lineas;
                        $to = ($pag + 1)* $total_lineas;
                        $subtotal = 0;
                    @endphp

                    @for ($i = $init; $i < $to; $i++)

                        @php
                            $p = $array_productos[$i]
                        @endphp

                        <?php
                            $subtotal += $p->unit_price * $p->cant;
                        ?>

                        <tr style="border-bottom: 0px;" height="10px" >
                            <td style="font-size:12px;text-align: right;"><span class="{{$p->class}}">{{$p->cant}}</span></td>
                            <td style="font-size:12px;text-align: left;"><span class="{{$p->class}}">{{$p->unity}} {{$p->name}}</span></td>
                            <td style="font-size:12px;text-align: center;"><span class="{{$p->class}}">{{$p->iva}}</span></td>
                            <td style="font-size:12px;text-align: right;"><span class="{{$p->class}}">{{number_format($p->unit_price, 2, ',', '.')}}</span></td>
                            <td style="font-size:12px;text-align: right;"><span class="{{$p->class}}">{{$p->total}}</span></td>
                        </tr>

                    @endfor

                    <?php $subtotal_pagina += $subtotal;?>

                </table>

                <footer style="height:150px;border: 1px solid #999797;">
                    <table>
                      <tr style="padding: 0; ">
                        <td style=" text-align: left; width: 140px; border-right:0px">
                           <img src="{{$qr_url}}" style="padding: 0; width: 100%; ">
                        </td>
                        <td style="text-align: left; width: 240px; padding: 0px 10px;border-right:0px">
                          <span style="font-size:12px;font-weight:bold;line-height: 18px;">
                              Fec. Vto. de CAE: {{\Carbon\Carbon::parse($invoice->date_expiration)->format('d/m/Y')}}
                          </span><br>
                          <span style="font-size:12px;font-weight:bold;line-height: 18px;">CAE: {{$invoice->cae}}</span><br><br>
                          <img src="{{public_path('afip.png')}}" width="40%"><br>
                          <span style="font-size:14px;font-weight:bold">Comprobante Autorizado</span><br>
                          <span style="font-size:12px;float:right;margin-top:20px">Pag. {{$pag+1}}</span>
                        </td>

                        <td style="text-align:left; width: 140px;">
                            @if($pag + 1 == $paginas)
                                <span style="font-size:14px; font-weight: bold;line-height: 22px;">Importe Neto</span><br>
                                @foreach ($alicuotas_array as $item)
                                    <span style="font-size:14px; font-weight: bold;line-height: 22px;">I.V.A {{$item->name}}</span><br>
                                @endforeach
                                <span style="font-size:14px; font-weight: bold;line-height: 22px;">Perc IB {{round($invoice->iibb,2)}}%</span><br>
                                <span style="font-size:14px; font-weight: bold;line-height: 22px;">Total Final</span>
                            @else
                                <span style="font-size:14px; font-weight: bold;line-height: 22px;">Subtotal</span>
                            @endif
                        </td>

                        <td style="text-align:right;  width: 143px;">
                            @if($pag + 1 == $paginas)
                                <span style="font-size:13px;line-height: 22px;margin-right:32px">${{number_format($invoice->imp_neto, 2, ',', '.')}} </span><br>
                                @foreach ($alicuotas_array as $item)
                                    <span style="font-size:13px;line-height: 22px;text-align:right">${{$item->value}} </span><br>
                                @endforeach
                                <span style="font-size:13px;line-height: 22px;text-align:right">${{number_format($invoice->imp_tot_conc, 2, ',', '.')}} </span><br>
                                <span style="font-size:13px;line-height: 22px;text-align:right">${{number_format($invoice->imp_total, 2, ',', '.')}}</span>
                            @else
                            <span style="font-size:13px;line-height: 22px;text-align:right">${{number_format($subtotal_pagina, 2, ',', '.')}}</span>
                            @endif
                        </td>
                      </tr>
                    </table>
                </footer>

            </div>
        </body>
    @endfor
<html>
