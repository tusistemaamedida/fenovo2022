import axios from 'axios';
import { createApp } from 'vue'

import Productos from './components/Productos'
import Localidades from './components/Localidades'
import Pagination from 'laravel-vue-pagination'



window.axios = axios;

const app = createApp({})

app.component('productos', Productos)
app.component('localidades', Localidades)

app.component('Pagination', Pagination)

app.mount('#app'); 