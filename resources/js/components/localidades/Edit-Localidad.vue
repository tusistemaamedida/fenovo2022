<template>
    <div class="modal fade" id="editarLocalidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form @submit.prevent="updateLocalidad(localidad.id)">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar localidad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nombre">Localidad</label>
                            <input type="text" name="nombre" class="form-control" v-model="localidad.nombre">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Departamento</label>
                            <input type="text" name="departamento" class="form-control" v-model="localidad.departamento">
                        </div>
                        <div class="form-group">
                            <label for="nombre">Provincia</label>
                            <input type="text" name="provincia" class="form-control" v-model="localidad.provincia">
                        </div>
                        <div class="form-group mt-5 mb-5">
                            <span v-for="error in errors" class=" text-danger " :key="error.name">
                                @{{ error }}
                            </span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>