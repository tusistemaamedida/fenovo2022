<div class="col-12">
    <div id="filepicker" style="width: 100% !important">
        <!-- Button Bar -->
        <div class="button-bar" style="margin-bottom: 15px;">
            <div class="btn btn-success fileinput">
                <i class="fa fa-upload"></i> Subir imágen
                <input type="file" name="files[]" multiple id="btn-file">
            </div>

            <button type="button" class="btn btn-danger delete-all">
                <i class="fa fa-trash"></i> Eliminar todas
            </button>
        </div>

        <!-- Files -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="column-preview">Imágen</th>
                        <th class="column-name">NombreS</th>
                        <th class="column-size">Tamaño</th>
                        <th class="column-date">Modificada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="files"></tbody>
                <tfoot><tr><td colspan="5">No hay imágenes.</td></tr></tfoot>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-container text-center"></div>

        <!-- Drop Window -->
        <div class="drop-window">
            <div class="drop-window-content">
                <h3><i class="fa fa-upload"></i> Drop files to upload</h3>
            </div>
        </div>
    </div>
</div>
<div id="crop-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Realizar selección</h3>
                <button type="button" class="close rounded-pill btn btn-sm btn-icon btn-light btn-hover-primary m-0" data-dismiss="modal" aria-label="Close">
                  <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-x" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                  </svg>
                </button>
              </div>
            <div class="modal-body">
                <div class="alert alert-warning crop-loading">Cargando imágen...</div>
                <div class="crop-preview"></div>
            </div>
            <div class="modal-footer" style="justify-content:center !important">
                <button type="button" class="btn btn-dark pull-left" data-dismiss="modal">Cancelar</button>
                <div class="crop-rotate">
                    <button type="button" class="btn  btn-primary btn-xs  crop-rotate-left" title="Rotar a la izquierda">
                        <i class="fa fa-undo" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn  btn-primary btn-xs  crop-flip-horizontal" title="Flip horizontal">
                        <i class="fas fa-arrows-alt-h"></i>
                    </button>
                    <button type="button" class="btn  btn-primary btn-xs  crop-rotate-right" title="Rotar a la derecha">
                        <i class="fa fa-redo" aria-hidden="true"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-success crop-save" data-loading-text="Guardando...">Guardar</button>
            </div>
        </div>
    </div>
</div>
