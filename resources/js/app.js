const URL_SERVER = APP_URL;

var app = Vue.createApp({

    data() {
        return {
            nuevoNombre: '',
            localidades: [],
            errors: [],
        }
    },
    created() {
        this.getLocalidades();
    },
    methods: {
        getLocalidades: function () {
            const urlLocalidades = URL_SERVER + '/getLocalidades';
            axios.get(urlLocalidades).then(response => {
                this.localidades = response.data
            })
        },
        destroyLocalidad: function (id) {
            const urlDestroy = URL_SERVER + '/destroyLocalidad/' + id;
            axios.delete(urlDestroy).then(response => {
                toastr.info('Localidad', 'Eliminada');
                this.getLocalidades();
            })
        },
        createLocalidad: function () {
            var urlStore = URL_SERVER + '/storeLocalidad';

            console.log(this.nuevoNombre);

            return false;

            axios.post(urlStore, {
                nombre: this.nuevoNombre,
            }).then(response => {

                this.getLocalidades();
                this.nuevoNombre = '';
                this.errors = [];
                jQuery('#createLocalidad').modal('hide');
                toastr.info('Localidad', 'Agregada');
            }).catch(error => {
                this.errors = error.response.data
            })
        }
    }
})

app.mount("#app-localidades");