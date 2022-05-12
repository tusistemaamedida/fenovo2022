<table>
    <tr>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Desde</th>
        <th>Hacia</th>
        <th>Entrada (Kgrs)</th>
        <th>Salida (Kgrs)</th>
        <th>Stock(Kgrs)</th>
        <th>Stock(U)</th>
        <th>Bultos</th>
    </tr>
    @foreach ($movimientos as $m)
    <tr>
        <td>{{\Carbon\Carbon::parse($m->movement->created_at)->format('d/m/Y')}}</td>
        <td>{{$m->movement->type}}</td>
        <td>{{$m->movement->From($m->movement->type)}}</td>
        <td>{{$m->movement->To($m->movement->type)}}</td>
        <td>{{$m->entry}}</td>
        <td>{{$m->egress}}</td>
        <td>{{$m->balance}}</td>
        <td>{{(int)($m->balance*$producto->unit_weight)}}</td>
        <td>{{(int)(($m->balance*$producto->unit_weight)/$m->unit_package)}}</td>
    </tr>
    @endforeach
</table>