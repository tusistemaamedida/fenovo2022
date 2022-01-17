<div id="editpopup" class="editpopup offcanvas offcanvas-right kt-color-panel p-5">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-3">

        <h4 class="font-size-h4 font-weight-bold m-0" id="title-modal"> Usuario </h4>

        <a href="#" class="btn btn-sm btn-icon btn-light btn-hover-primary close_modal_user">
            <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
            </svg>
        </a>
    </div>

    <form id="formUser">
        @csrf
        <div class="row">
            <div class="col-12" id="insertByAjax"></div>
            <div class="col-12">
                <button type="reset" class="btn btn-outline-secondary close_modal_user"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" style="float: right" id="btn-guardar-user"><i class="fa fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>
</div>
