
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'

// EXTRAS
import Vuetify from 'vuetify'
import VueI18n from 'vue-i18n'
//import BootstrapVue from 'bootstrap-vue'
import currency from 'v-currency-field'

// CSS EXTRAS
import 'vuetify/dist/vuetify.min.css'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import 'animate.css/animate.min.css' 
import 'v-currency-field/dist/index.css'

// COMPONENTES VUE
import home from './components/Dashboard.vue'
import empresas from './components/Empresas.vue'
import clientes from './components/Clientes.vue'
import productos from './components/Productos.vue'

//Vue.use(BootstrapVue);
Vue.use(currency);

// TRADUCCION PERSONALIZADA PARA VUETIFY
Vue.use(VueI18n);
const messages = {
  es: {
    $vuetify: {
      dataIterator: {
        rowsPerPageText: "Registros por página:",
        rowsPerPageAll: "Todos",
        pageText: "{0}-{1} de {2}",
        noResultsText: "No se encontraron registros coincidentes.",
        nextPage: "Next page",
        prevPage: "Previous page"
      },
      dataTable: {
        rowsPerPageText: "Registros por página:"
      },
      noDataText: "No se encontraron registros coincidentes."
    },
  }
}
// Create VueI18n instance with options
const i18n = new VueI18n({
  locale: 'es', // set locale
  messages, // set locale messages
})

// SE DEFINEN LOS PARAMETROS DE VUETIFY
Vue.use(Vuetify, {
  lang: {
    t: (key, ...params) => i18n.t(key, params)
  },
  options: {
    themeVariations: ['primary', 'secondary', 'accent'],
    extra: {
      mainToolbar: {
        color: 'primary',
      },
      sideToolbar: {
      },
      sideNav: 'primary',
      mainNav: 'primary lighten-1',
      bodyBg: '',
    }
  }
})

// COMPONENTES VUE - CRUDS
Vue.component('ui-login', require('./UI-Login.vue'));
Vue.component('ui-principal', require('./UI-Principal.vue'));
Vue.component('ui-btntop', require('./UI-BtnTop.vue'));
Vue.component('ui-theme-settings', require('./UI-ThemeSettings.vue'));

Vue.use(VueRouter)

let router = new VueRouter({
  routes: [
    {
      path: '/home',
      component: home,
    },
    {
      path: '/empresas',
      component: empresas,
    },
    {
      path: '/clientes',
      component: clientes,
    },
    {
      path: '/productos',
      component: productos,
    },
    { path: '*', redirect: '/home' }
  ]
})

const app = new Vue({
    // DIV PRINCIPAL DE CONTENIDO
    el: '#app',
    // URLS DE VUEJS
    router
    
});
