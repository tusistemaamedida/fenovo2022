<table>
    @foreach($arrPresentaciones as $presentacion)
    <tr>
        <td>{{ $presentacion->cod_fenovo }}</td>
        <td>{{ $presentacion->presentacion }}</td>
    </tr>
    @endforeach
</table>