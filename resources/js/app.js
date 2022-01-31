require('./bootstrap');

window.Vue = require('vue').default;

import store from './store'
import router from './router'
import Vuetify from 'vuetify';
import HighchartsVue from 'highcharts-vue'
import VuePaginate from 'vue-paginate'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'

Vue.component('header-component', require('./components/header/headerComponent.vue').default);
Vue.component('navbar-guest', require('./components/menus/navbarGuest.vue').default);

Vue.component('posts-component', require('./pages/post/PostsComponent').default);
Vue.component('post-component', require('./pages/post/PostComponent').default);

Vue.use(Vuetify);
Vue.use(HighchartsVue)
Vue.use(VuePaginate)

const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify()
});