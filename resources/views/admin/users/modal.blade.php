<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <form id="formData" autocomplete="false">
        @csrf
        <div class="row  mb-3">
            <div class="col-12" id="insertByAjax"></div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="reset" class="btn btn-outline-primary close_modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary btn-guardar" onclick="store('{{ route('users.store') }}')" style="float: right"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-primary btn-actualizar" onclick="update('{{ route('users.update') }}')" style="float: right"><i class="fa fa-save"></i> Actualizar</button>
            </div>
        </div>
    </form>
</div>