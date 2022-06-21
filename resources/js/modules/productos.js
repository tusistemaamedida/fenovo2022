var appProducto = Vue.createApp({

    data() {
        return {
            pagina:1,
            cargando:null,
            txtProducto: '',
            productos: [],
        }
    },
    mounted() {
        this.getProductos();
        jQuery(function() {
            jQuery("#buscarProducto").focus();
        })
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
        buscarRegistro: function(){
            this.getProductos()
        },
        
    }
})

appProducto.mount("#app-productos");