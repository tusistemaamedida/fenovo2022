<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData">
        @csrf
        <div class="row">
            <div class="col-12" id="insertByAjax"></div>
            <div class="col-12">
                <button type="reset" class="btn btn-outline-secondary close_modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary btn-guardar" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-primary btn-actualizar" style="float: right"><i class="fa fa-save"></i> Actualizar</button>
            </div>
        </div>
    </form>
</div>