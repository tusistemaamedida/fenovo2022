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
                                            Productos
                                        </h4>
                                    </div>
                                    <div class="icons d-flex">

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
                                    <input id="buscarProducto" name="buscarProducto" v-model="txtProducto" type="text" class="form-control" @keyup ="buscarRegistro">
                                </div>
                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-12">                                 
                                <div class="table-responsive">
                                    <table class="table table-hover table-condensed text-center" id="tablaProductos">
                                        <thead>
                                            <tr>
                                                <th style=" width: 3%;">CodFenovo</th>
                                                <th style=" width: 30%;">Producto</th>
                                                <th style=" width: 3%;">Unidad</th>
                                                <th style=" width: 40%;">Proveedor</th>
                                                <th style=" width: 10%;">Costo</th>
                                                <th style=" width: 3%;">Historial</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                            <tr v-for="producto in productos.data" :key="producto.id">
                                                <td> {{ producto.cod_fenovo }}</td>
                                                <td class="text-left"> 
                                                    <a :href="`${producto.linkOferta}`" class=" text-primary">
                                                       {{ producto.name }}
                                                    </a>
                                                </td>
                                                <td> {{ producto.unit_type }}</td>
                                                <td> {{ producto.proveedor }}</td>
                                                <td> {{ producto.costfenovo }}</td>
                                                <td> 
                                                    <a :href="`${producto.linkHistorial}`" class=" text-primary">
                                                       <i class="fa fa-list" aria-hidden="true"></i>
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
                                    <div class="nav d-flex justify-content-center">
                                        <pagination :data="productos" @pagination-change-page="getProductos" ></pagination>
                                    </div>
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
            txtProducto: '',
            productos: {},
        }
    },
    mounted() {
        jQuery(function () {
            jQuery("#buscarProducto").focus();
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
        getProductos(page=1) {
            this.txtProducto = (localStorage.txtProducto)?localStorage.txtProducto:'';
            const urlProductos = APP_URL + `/getProductos?page=${page}&txtProducto=${this.txtProducto}`;
            axios.get(urlProductos).then(response => {
                this.productos = response.data
            })
        },
        // Buscar productos
        buscarRegistro: function () {
            this.getProductos()
            localStorage.setItem('txtProducto', this.txtProducto);
        },

    }
}
</script>