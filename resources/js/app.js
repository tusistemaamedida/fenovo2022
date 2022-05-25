
var urlLocalidades = APP_URL + '/getLocalidades';

new Vue({
    el: '#app-localidades',
    created: function () {
        this.getLocalidades();
    },
    data: {
        lists: []
    },
    methods: {
        getLocalidades: function () {
            axios.get(urlLocalidades).then(response => {
                this.lists = response.data
            })
        }
    }

})