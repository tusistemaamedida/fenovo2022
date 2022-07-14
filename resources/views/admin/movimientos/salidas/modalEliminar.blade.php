<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData" autocomplete="false">
        @csrf
        <div class="row  mb-3">
            <div class="col-12" id="insertByAjax"></div>
        </div>
        <div class="row">
            <div class="col-6">
                <button type="reset" class="btn btn-outline-dark close_modal">
                    <i class="fa fa-times"></i> Cancelar
                </button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-danger" onclick="borrarPendiente()" >
                    <i class="fa fa-trash "></i> Eliminar
                </button>
            </div>
        </div>
    </form>
</div>