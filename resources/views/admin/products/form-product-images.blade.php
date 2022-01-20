<div class="col-12">
    <div id="filepicker" style="width: 100% !important">
        <!-- Button Bar -->
        <div class="button-bar" style="margin-bottom: 15px;">
            <div class="btn btn-success fileinput">
                <i class="fa fa-upload"></i> Subir imágen
                <input type="file" name="files[]" multiple>
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
                        <th class="column-preview">Preview</th>
                        <th class="column-name">Name</th>
                        <th class="column-size">Size</th>
                        <th class="column-date">Modified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="files"></tbody>
                <tfoot><tr><td colspan="5">No files where found.</td></tr></tfoot>
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
                <span class="close" data-dismiss="modal">&times;</span>
                <h4 class="modal-title">Make a selection</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning crop-loading">Loading image...</div>
                <div class="crop-preview"></div>
            </div>
            <div class="modal-footer">
                <div class="crop-rotate">
                    <button type="button" class="btn btn-default btn-sm crop-rotate-left" title="Rotate left">
                        <i class="fa fa-undo"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm crop-flip-horizontal" title="Flip horizontal">
                        <i class="fa fa-arrows-h"></i>
                    </button>
                    <!-- <button type="button" class="btn btn-default btn-sm crop-flip-vertical" title="Flip vertical">
                        <i class="fa fa-arrows-v"></i>
                    </button> -->
                    <button type="button" class="btn btn-default btn-sm crop-rotate-right" title="Rotate right">
                        <i class="fa fa-repeat"></i>
                    </button>
                </div>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success crop-save" data-loading-text="Saving...">Save</button>
            </div>
        </div>
    </div>
</div>
