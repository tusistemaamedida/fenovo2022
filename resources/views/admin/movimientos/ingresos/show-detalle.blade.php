@isset($movimientos)
    <div class="table-datapos">
        <div class="table-responsive">
            <table class=" table table-hover table-sm text-center">
                <tr class=" bg-dark text-white">
                    <th>Cod fenovo</th>
                    <th>Producto</th>
                    <th>Medida</th>
                    <th>Kgrs</th>
                    <th>Presentación</th>
                    <th>$_Costo </th>
                    <th>Bultos</th>
                    <th>$_Total</th>
                    <th>Unidades</th>
                    <th>#</th>
                </tr>

                @php
                    $total = 0;
                @endphp

                @foreach ($movimientos as $movimiento)
                    @php
                        $total += $movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos;
                    @endphp
                    <tr>
                        <td> {{ $movimiento->product->cod_fenovo }} </td>
                        <td class=" text-left"> {{ $movimiento->product->name }}</td>
                        <td> {{ $movimiento->unit_type }} </td>
                        <td> {{ number_format($movimiento->product->unit_weight * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                        </td>
                        <td> {{ $movimiento->unit_package }} </td>
                        <td> {{ $movimiento->cost_fenovo }}</td>
                        <td> {{ $movimiento->bultos }}</td>
                        <td> {{ number_format($movimiento->cost_fenovo * $movimiento->unit_package * $movimiento->bultos, 2, ',', '.') }}
                        </td>
                        <td> {{ number_format($movimiento->unit_package * $movimiento->bultos, 0, '', '') }}
                        </td>
                        <td>
                            <a href="javascript:void(0)"
                                onclick="editarMovimiento(
                                '{{ $movimiento->id }}', 
                                '{{ $movimiento->bultos }}', 
                                '{{ $movimiento->product->id }}',
                                '{{ $movimiento->product->cod_fenovo }}',
                                '{{ $movimiento->product->name }}',
                            )">
                                <i class=" fa fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="10">
                        </hr>
                    </th>
                </tr>
                <tr class=" bg-dark text-black-50">
                    <th>Totales</th>
                    <th></th>
                    <th></th>
                    <th>{{ number_format($movement->totalKgrs(), 2, ',', '.') }}</th>
                    <th></th>
                    <th></th>
                    <th> {{ $movimientos->sum('bultos') }} </th>
                    <th> {{ number_format($total, 2, ',', '.') }} </th>
                    <th></th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
@endisset
                            