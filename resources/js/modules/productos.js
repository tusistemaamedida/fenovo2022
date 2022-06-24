var appProducto = Vue.createApp({

    data() {
        return {
            pagina: 1,
            cargando: null,
            txtProducto: '',
            productos: [],
        }
    },
    mounted() {
        this.txtProducto = (localStorage.txtProducto) ? localStorage.txtProducto : '';
        jQuery("#buscarProducto").focus();
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

            const urlProductos = URL_SERVER + `/getProductos?page=${pagina}&codfenovo=${txtBuscar}&name=${txtBuscar}`;
            axios.get(urlProductos).then(response => {
                this.productos = response.data
            })
        },
        // Buscar productos
        buscarRegistro: function () {
            localStorage.setItem('txtProducto', this.txtProducto);
            this.getProductos()
        },
        // Borrar producto
        destroyProducto: async function (producto) {

            if (!confirm('Confirma eliminar ?')) return
            const urlDestroy = URL_SERVER + '/productos/destroy';
            await axios.post(urlDestroy, { id:producto.id })
                .then(response => {
                    this.getProductos();
                    toastr.info('Ok', 'Eliminado');
                }).catch(function (error) {
                    alert('something went wrong ', error)
                });
        }

    }
})

appProducto.mount("#app-productos");