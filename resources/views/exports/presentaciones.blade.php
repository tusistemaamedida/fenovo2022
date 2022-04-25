<table>
    <tr>
        <td colspan="2">{{ $data }}</td>
    </tr>
    @foreach($arrPresentaciones as $presentacion)
    <tr>
        <td>{{ $presentacion->cod_fenovo }}</td>
        <td>{{ $presentacion->presentacion }}</td>
    </tr>
    @endforeach
</table>