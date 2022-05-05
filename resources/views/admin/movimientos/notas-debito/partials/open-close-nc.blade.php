<div id="closeSalida" class="offcanvas offcanvas-right kt-color-panel p-5">
    <form action="{{route('guardar.nd')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="session_list_id" id="session_list_id" value="">
                <h6>CERRAR NOTA DE DEBITO?</h6>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class="text-dark">Asociar a número de factura</label>
                <fieldset class="form-group mb-3 d-flex">
                    <select class="js-example-basic-single js-states form-control bg-transparent" name="voucher_number" id="voucher_number"> </select>
                </fieldset>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary" id="close_modal_salida"><i class="fa fa-times"></i> NO</button>
                <button type="submit" class="btn btn-primary" id="btnCloseSalida" style="float: right" disabled><i class="fa fa-save"></i> SI</button>
            </div>
        </div>
    </form>
</div>
