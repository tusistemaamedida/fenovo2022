<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData">
        @csrf
        <div class="row">
            <div class="col-12" id="insertByAjax"></div>
        </div>
        <div class="row">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-primary close_modal">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary btn-actualizar" onclick="actualizarProducto()">
                    <i class="fa fa-save"></i> Actualizar
                </button>
            </div>
        </div>
    </form>
</div>