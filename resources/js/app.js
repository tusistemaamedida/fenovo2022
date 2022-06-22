import axios from 'axios';
import { createApp } from 'vue'
import Pagination from 'laravel-vue-pagination'

// Productos
import Productos from './components/productos/Productos'

// Localidades
import Localidades from './components/localidades/Localidades'



window.axios = axios;

const app = createApp({})

app.component('productos', Productos)
app.component('localidades', Localidades)

app.component('Pagination', Pagination)

app.mount('#app'); 