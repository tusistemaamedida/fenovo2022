<form method="POST" v-on:submit.prevent="createLocalidad">
    <div id="createLocalidad" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn btn-light-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">Agregar localidad</h5>
                </div>
                <div class="modal-body">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" v-model="nuevoNombre">
                    <span v-for="error in errors" class="text-danger">@{{ error }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Guardar" />
                </div>
            </div>
        </div>
    </div>
</form>