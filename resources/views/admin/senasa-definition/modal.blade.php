<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData">
        @csrf
        <div class="row">
            <div class="col-12" id="insertByAjax"></div>
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary close_modal"><i class="fa fa-times"></i> Cerrar</button>
                <button type="button" class="btn btn-primary btn-guardar" onclick="store('{{ route('senasa-definition.store') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-primary btn-actualizar" onclick="update('{{ route('senasa-definition.update') }}')" style="float: right"><i class="fa fa-save"></i> Actualizar</button>
            </div>
        </div>
    </form>
</div>