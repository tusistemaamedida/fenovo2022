
import axios from 'axios';
import { createApp } from 'vue'
import Pagination from 'laravel-vue-pagination'

window.jQuery = require('jquery');
window.$ = require('jquery');
window.Aos = require('aos');
window.toastr = require('toastr');
window.Popper = require('@popperjs/core');

require('select2');
require('datatables.net-bs4');

// Componentes
import Productos from './components/productos/Productos'
import Localidades from './components/localidades/Localidades'

window.axios = axios;

const app_productos = createApp({})
const app_localidades = createApp({})

app_productos.component('productos', Productos)
app_productos.component('Pagination', Pagination)
app_productos.mount('#app-productos'); 

app_localidades.component('localidades', Localidades)
app_localidades.component('Pagination', Pagination)
app_localidades.mount('#app-localidades'); 
