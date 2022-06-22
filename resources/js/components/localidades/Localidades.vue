<template>
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <div class="card card-custom gutter-b bg-transparent shadow-none border-0">
                                <div class="card-header align-items-center  border-bottom-dark px-0">
                                    <div class="card-title mb-0">
                                        <h4 class="card-label mb-0 font-weight-bold text-body">
                                            Localidades
                                        </h4>
                                    </div>
                                    <div class="icons d-flex">
                                        <a href="#" data-toggle="modal" data-target="#crearLocalidad"
                                            class="ml-2">
                                            <i class="fa fa-2x fa-plus-circle text-primary" @click="limpiarLocalidad"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="card card-body gutter-b bg-white border-0">
                        <div class="row">
                            <div class="col-9"> 
                            </div>
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            Buscar  &nbsp; <i class=" fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input id="buscarLocalidad" name="buscarLocalidad" type="text" class="form-control" @keyup ="buscarRegistro" v-model="txtLocalidad">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-condensed" id="tablaLocalidades">
                                        <thead>
                                            <tr>
                                                <th>Localidad</th>
                                                <th>Departamento</th>
                                                <th>Provincia</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(localidad,index) in localidades.data" :key="index">
                                                <td style=" width: 50%;"> {{ localidad.nombre }}</td>
                                                <td style=" width: 20%;"> {{ localidad.departamento }}</td>
                                                <td style=" width: 20%;"> {{ localidad.provincia }} </td>
                                                <td style=" width: 5%;"> 
                                                    <a href="javascript:void(0)" @click.prevent="editarLocalidad(localidad)">
                                                        Editar
                                                    </a>
                                                </td>
                                                <td style=" width: 5%;"> 
                                                    <a href="javascript:void(0)" @click.prevent="destroyLocalidad(localidad.id)">
                                                        Borrar 
                                                    </a> 
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 "> 
                                <div class="table-responsive">
                                    <pagination :data="localidades" @pagination-change-page="getLocalidades">
                                    </pagination>
                                </div>                                       
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            page: 1,
            txtLocalidad: '',
            localidades: {},
            errors: [],
            localidad: {
                id: '',
                nombre: '',
                departamento: '',
                provincia: '',
            },
        }
    },
    mounted() {
        this.txtLocalidad = (localStorage.txtLocalidad)?localStorage.txtLocalidad:'';
        jQuery(function () {
            jQuery("#buscarLocalidad").focus();
        })
        this.getLocalidades();
    },
    watch: {
        txtLocalidad(newLocalidad) {
            localStorage.txtLocalidad = newLocalidad;
        }
    },
    methods: {
        // Obtener localidades
        getLocalidades: function (page=1) {
            let txtBuscar = this.txtLocalidad;
            const urlLocalidades = APP_URL + `/getLocalidades?page=${page}&name=${txtBuscar}`;
            axios.get(urlLocalidades).then(response => {
                this.localidades = response.data
            })
        },
        
        buscarRegistro: function(){
            localStorage.setItem('txtLocalidad', this.txtLocalidad);
            this.getLocalidades()
        },
        // Limpiar datos
        limpiarLocalidad: function () {
            this.localidad.id = '';
            this.localidad.nombre = '';
            this.localidad.departamento = '';
            this.localidad.provincia = '';
        },
        // Guardar
        storeLocalidad: async function () {
            var urlStore = APP_URL + '/storeLocalidad';

            await axios.post(urlStore, {
                nombre: this.localidad.nombre,
                departamento: this.localidad.departamento,
                provincia: this.localidad.provincia,
            }).then(response => {
                this.limpiarLocalidad();
                this.errors = [];
                this.getLocalidades();
                toastr.info('Localidad', 'Agregada');
                jQuery('#crearLocalidad').modal('hide');
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        },
        // Editar
        editarLocalidad: async function (localidad) {
            this.localidad.id = localidad.id;
            this.localidad.nombre = localidad.nombre;
            this.localidad.departamento = localidad.departamento;
            this.localidad.provincia = localidad.provincia;
            jQuery('#editarLocalidad').modal('show');
        },
        // Actualizar
        updateLocalidad: async function (id) {
            var urlUpdate = APP_URL + '/updateLocalidad/' + id;
            axios.put(urlUpdate, this.localidad)
                .then(response => {
                    this.limpiarLocalidad();
                    this.errors = [];
                    this.getLocalidades();
                    toastr.info('Localidad', 'Actualizada');
                    jQuery('#editarLocalidad').modal('hide');
                }).catch(error => {
                    this.errors = error.response.data
                });
        },
        // Borrar 
        destroyLocalidad: async function (id) {
            if (!confirm('Confirma eliminar ?')) return
            const urlDestroy = APP_URL + '/destroyLocalidad/' + id;
            await axios.delete(urlDestroy).then(response => {
                this.localidades = this.localidades.filter(localidad => localidad.id !== id)
                toastr.info('Ok', 'Localidad eliminada ');
            });
        }
    }   
}
</script>
