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

                    <div class="card card-body gutter-b bg-white border-0" data-aos="fade-up">
                        <div class="row">
                            <div class="col-8"> 
                                Valor buscado <span class=" font-weight-bolder"> @{{ txtLocalidad }} </span>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class=" fa fa-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" @keyup ="buscarRegistro" v-model="txtLocalidad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped" id="tablaLocalidades">
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
                                            <tr v-for="(localidad,index) in localidades" :key="index">
                                                <td class="w-25"> @{{ localidad.nombre }}</td>
                                                <td> @{{ localidad.departamento }}</td>
                                                <td> @{{ localidad.provincia }} </td>
                                                <td> <a href="javascript:void(0)" class="btn btn-light btn-sm"
                                                        @click.prevent="editarLocalidad(localidad)">Editar</a></td>
                                                <td> <a href="javascript:void(0)" class="btn btn-light btn-sm text-danger"
                                                        @click.prevent="destroyLocalidad(localidad.id)">Borrar </a> </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <button class="btn btn-sm btn-outline-dark">
                                    <i class="fa fa-arrow-alt-circle-left" @click="anteriorRegistro"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-dark">
                                    <i class="fa fa-arrow-alt-circle-right" @click="siguienteRegistro"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.localidades.create')
        @include('admin.localidades.edit')
    </div>
</template>

<script>
export default {
   data() {
        return {
            pagina: 1,
            cargando: null,
            txtProducto: '',
            productos: [],
        }
    },
    mounted() {
        this.txtProducto = (localStorage.txtProducto)?localStorage.txtProducto:'';
        jQuery("#buscarProducto").focus();
            jQuery(function () {
        })
        this.getProductos();
    },
    watch: {
        txtProducto(newProducto) {
            localStorage.txtProducto = newProducto;
        }
    },
    methods: {
        // Obtener productos
        getProductos: function () {
            let pagina = this.pagina;
            let txtBuscar = this.txtProducto;

            const urlProductos = APP_URL + `/getProductos?page=${pagina}&codfenovo=${txtBuscar}&name=${txtBuscar}`;
            axios.get(urlProductos).then(response => {
                this.productos = response.data
            })
        },
        // Buscar productos
        buscarRegistro: function () {
            localStorage.setItem('txtProducto', this.txtProducto);
            this.getProductos()
        },

    }
}
</script>