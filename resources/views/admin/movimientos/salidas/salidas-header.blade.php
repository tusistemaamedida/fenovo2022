<header>
    <div class="row">
        <div class="col-12">
            <table class="table table-borderless">
                <tr>
                    <td style="width: 35%"> Salida de Mercaderías </td>
                    <td style="width: 35%; font-size:16px" class=" text-center"> Fenovo S.A. </td>
                    <td style="width: 30%" class=" text-right"> Fecha <strong> {{ date(now()) }}</strong> </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td>Destino : <strong> {{ $destino->description }} </strong></td>
                    <td>Items <strong> {{ $session_products->count('id') }}</strong> - Bultos <strong> {{ $session_products->sum('quantity') }}</strong></td>
                    <td>Página :: <strong> <span class="pagenum"></span> </strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</header>