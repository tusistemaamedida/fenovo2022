<div id="closeSalida" class="offcanvas offcanvas-right kt-color-panel p-5">
    <form action="{{route('guardar.salida')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="session_list_id" id="session_list_id" value="">
                <h6>CERRAR SALIDA</h6>
                <label class="text-dark">
                    Al cerrar la salida, el stock se actulizará definitivamente, desea continuar ?
                </label>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class="text-dark">Ingrese una identificación</label>
                <input type="text" name="voucher_number" id="voucher_number" class="form-control" autofocus>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <label class="text-dark">Flete <strong> <span id="montoFlete"></span> </strong> % </label>
            </div>
            <div class="col-6">
                <input type="text" name="flete" id="flete" value="0" class="form-control text-center">
            </div>

        </div>

        <div class="row mt-5">
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary" id="close_modal_salida"><i class="fa fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnCloseSalida" style="float: right"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>