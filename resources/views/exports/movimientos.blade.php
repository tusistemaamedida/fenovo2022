<table>
    <tr>
        <td colspan="9">{{ $data }}</td>
    </tr>
    @foreach($arrMovements as $arrMovement)
    <tr>
        <td>{{ $arrMovement->origen       }}</td>
        <td>{{ $arrMovement->id         }}</td>
        <td>{{ $arrMovement->orden         }}</td>
        <td>{{ $arrMovement->fecha      }}</td>
        <td>{{ $arrMovement->tipo       }}</td>
        <td>{{ $arrMovement->codtienda  }}</td>
        <td>{{ $arrMovement->codproducto}}</td>
        <td>{{ $arrMovement->cantidad   }}</td>
        <td>{{ $arrMovement->unidad   }}</td>
    </tr>
    @endforeach
</table>