<div id="movimientoPopup" class="movimientoPopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formDataMovimiento">
        @csrf

        <input type="hidden" id="session_product_id" name="session_product_id" value=""/>

        <div class="row mb-3">
            <div class="col-12 text-center">
                <h4>Codigo fenovo <span id="mov_cod_fenovo"></span></h4>
            </div>
        </div>    
        <div class="row mb-3">
            <div class="col-6">
                Bultos
            </div>
            <div class="col-6">
                <input type="number" id="session_product_quantity" name="session_product_quantity" value="" class="form-control text-center" />
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary" onclick="cerrarModal()">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary" onclick="actualizarMovimiento()">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </form>
</div>