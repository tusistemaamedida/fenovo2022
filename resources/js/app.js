const URL_SERVER = APP_URL;

var app = Vue.createApp({

    data() {
        return {
            localidad: {
                id: '',
                nombre: '',
                departamento: '',
                provincia: '',
            },
            localidades: [],
            errors: [],
        }
    },
    created() {
        this.getLocalidades();
    },
    methods: {
        limpiarLocalidad: function () {
            this.localidad.id = '';
            this.localidad.nombre = '';
            this.localidad.departamento = '';
            this.localidad.provincia = '';
        },
        getLocalidades: function () {
            const urlLocalidades = URL_SERVER + '/getLocalidades';
            axios.get(urlLocalidades).then(response => {
                this.localidades = response.data
            })
        },
        destroyLocalidad: async function (id) {
            if (!confirm('Confirma eliminar ?')) return
            const urlDestroy = URL_SERVER + '/destroyLocalidad/' + id;
            await axios.delete(urlDestroy).then(response => {
                this.localidades = this.localidades.filter(localidad => localidad.id !== id)
                toastr.info('Ok', 'Localidad eliminada ');
            });
        },
        createLocalidad: function () {
            var urlStore = URL_SERVER + '/storeLocalidad';

            axios.post(urlStore, {
                nombre: this.localidad.nombre,
                departamento: this.localidad.departamento,
                provincia: this.localidad.provincia,
            }).then(response => {
                this.limpiarLocalidad();
                this.errors = [];
                toastr.info('Localidad', 'Agregada');
            }).catch(error => {
                this.errors = error.response.data
            })
        }
    }
})

app.mount("#app-localidades");