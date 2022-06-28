/* window.jQuery = require('jquery');
window.$ = require('jquery'); */
window.axios = require('axios');
window.Aos = require('aos');
window.toastr = require('toastr');
window.Popper = require('@popperjs/core');
/* window.dataTable = require('datatables.net-bs4'); */
/* window.Select2 =  require('select2'); */

import { createApp, defineAsyncComponent } from 'vue'
import Pagination from 'laravel-vue-pagination'

// Componentes
import Productos from './components/productos/Productos'
import Localidades from './components/localidades/Localidades'

window.axios = axios;

const app = createApp({})

const app_productos = createApp({})
const app_localidades = createApp({})

app_productos.component('productos', Productos)
app_productos.component('Pagination', Pagination)
app_productos.mount('#app-productos');

app_localidades.component('localidades', Localidades)
app_localidades.component('Pagination', Pagination)
app_localidades.mount('#app-localidades');

