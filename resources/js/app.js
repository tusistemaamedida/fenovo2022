const URL_SERVER = APP_URL;


var app = Vue.createApp({

    data() {
        return {
            pagina:1,
            localidades: [],
            errors: [],
            localidad: {
                id: '',
                nombre: '',
                departamento: '',
                provincia: '',
            },
        }
    },
    created() {
        this.getLocalidades(this.pagina);
    },
    methods: {
        // Obtener localidades
        getLocalidades: function (pagina) {
            console.log(pagina);
            const urlLocalidades = URL_SERVER + `/getLocalidades?page=${pagina}`;
            axios.get(urlLocalidades).then(response => {
                this.localidades = response.data.data
            })
        },
        siguienteRegistro: function(){
            this.pagina ++;
            this.getLocalidades(this.pagina);
        },
        anteriorRegistro: function(){
            if(this.pagina > 1) this.pagina --;
            this.getLocalidades(this.pagina);
        },
        buscarRegistro: function(){
            console.log('llega');
        },
        // Crear DataTable
        crearTabla: function () {
            this.$nextTick(() => {
                jQuery("#tablaLocalidades").DataTable({
                    lengthMenu : [[25, 50, -1], [25, 50, "Todos"]],
                    stateSave:true,
                    processing: true,
                    ordering:false,
                    autoWidth: false,
                });
            })
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
            var urlStore = URL_SERVER + '/storeLocalidad';

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
            var urlUpdate = URL_SERVER + '/updateLocalidad/' + id;
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
            const urlDestroy = URL_SERVER + '/destroyLocalidad/' + id;
            await axios.delete(urlDestroy).then(response => {
                this.localidades = this.localidades.filter(localidad => localidad.id !== id)
                toastr.info('Ok', 'Localidad eliminada ');
            });
        }
    }
})

app.mount("#app-localidades");