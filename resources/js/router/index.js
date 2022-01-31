// Importaciones
import Vue from 'vue'
import VueRouter from 'vue-router'
import homeComponent from '../pages/home/homeComponent.vue'
import createPostComponent from '../pages/post/createPostComponent.vue'
import PostComponent from '../pages/post/PostComponent.vue'
import analyticComponent from '../pages/analytic/analyticComponent.vue'

// asignar
Vue.use(VueRouter)

// rutas
const routes = [
    {
        path: '/',
        name: 'Root',
        component: homeComponent,
        props: true
    },
    {
        path: '/home',
        name: 'Home',
        component: homeComponent,
        props: true
    },
    {
        path: '/post',
        name: 'Post',
        component: createPostComponent,
        props: true
    },
    {
        path: '/post/:id',
        name: 'AnPost',
        component: PostComponent,
        props: true
    },
    {
        path: '/analytic',
        name: 'Analytics',
        component: analyticComponent,
        props: true
    }
]

// instancia
const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

// exportar objeto
export default router