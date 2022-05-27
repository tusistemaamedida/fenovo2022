<!-- Modal -->
<div class="modal fade" id="crearLocalidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form @submit.prevent="storeLocalidad">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva localidad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Localidad</label>
                        <input type="text" name="nombre" class="form-control" v-model="localidad.nombre">
                        <span v-if="errors['nombre']">
                            @{{ errors['nombre'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Departamento</label>
                        <input type="text" name="departamento" class="form-control" v-model="localidad.departamento">
                        <span v-if="errors['departamento']">
                            @{{ errors['departamento'] }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Provincia</label>
                        <input type="text" name="provincia" class="form-control" v-model="localidad.provincia">
                        <span v-if="errors['provincia']">
                            @{{ errors['provincia'] }}
                        </span>
                    </div>
                    <div class="form-group mt-5 mb-5">

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>

        </div>
    </div>
</div>