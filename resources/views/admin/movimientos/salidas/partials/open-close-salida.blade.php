<div id="closeSalida" class="offcanvas offcanvas-right kt-color-panel p-5" >
    <form action="{{route('guardar.salida')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="session_list_id" id="session_list_id" value="">
                <h6>CERRAR SALIDA</h6>
                <div class="form-group">
                    <label class="text-dark">Al cerrar la salida, el stock se actulizará definitivamente, desea continuar?</label>
                </div>

                <div class="form-group">
                    <label class="text-dark">Ingrese una identificación</label>
                    <input type="text" name="voucher_number" id="voucher_number">
                </div>
            </div>
            <div class="col-12">
                <button type="reset" class="btn btn-outline-secondary" id="close_modal_salida"><i class="fa fa-times"></i> Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btnCloseSalida" style="float: right"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>
