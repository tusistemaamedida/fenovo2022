<div id="createRemito" class="offcanvas offcanvas-right kt-color-panel p-5">
    <form action="{{route('print.remito')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="movement_id" id="movement_id_in_modal" value="">
                <h6>Generar Remito?</h6>
                <p>El importe total del movimiento es: $ <span id="total_in_span" style="font-weight: bold"></span></p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <label class="text-dark">Ingrese un importe</label>
                <fieldset class="form-group mb-3 d-flex">
                    <input type="number" class="js-states form-control bg-transparent" step="any" name="neto" id="neto" />
                </fieldset>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary" id="close_modal_salida"><i class="fa fa-times"></i> NO</button>
                <button type="submit" class="btn btn-primary" id="btnCreateRemito" style="float: right" target="_blank"><i class="fa fa-save"></i> SI</button>
            </div>
        </div>
    </form>
</div>
