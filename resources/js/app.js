
require('./bootstrap');

import 'material-design-icons-iconfont/dist/material-design-icons.css';
import '@mdi/font/css/materialdesignicons.css';
import '@fortawesome/fontawesome-free/css/all.css';

window.Vue = require('vue');


import vuetify from './vuetify'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import VuePageTransition from 'vue-page-transition'
Vue.use(VuePageTransition)


//import App from  './components/cisinfo.vue'

import App from  './components/Main'


import Inscription from './components/user/Inscription'
import Connexion from './components/user/connexion_agent'

import fr from 'vuetify/es5/locale/fr'
//import Accueil from  './components/Accueil'




const router = new VueRouter({
    mode: 'history',
    routes: [

        {
            path: '/',
            name: 'accueil',
            component: resolve => require(['./components/Accueil'],resolve),
            meta: { transition: 'overlay-left' },

        },
        /*{
            path: '/historique',
            name: 'historique',
            component: resolve => require(['./components/user/historique'],resolve),
            meta: { transition: 'overlay-left' },

        },*/


        {
            path: '/connexion',
            name: 'connexion',
            component: Connexion,
            meta: { transition: 'overlay-right' },
        },
        {
            path: '/inscription',
            name: 'inscrription',
            component: Inscription,
            meta: { transition: 'overlay-right' },
        },
        {
            path: '/validation_commande',
            name: 'validation',
            component: resolve => require(['./components/user/validation_commande'],resolve),
            meta: { transition: 'overlay-right' },
        },


        {
            path :'*',
            redirect: '/'
        },

    ],
})

router.beforeEach((to, from, next) => {
    //  js.Verifier_Route(to);
    // ...
    next()
})



const app = new Vue({
    vuetify,
    router,
    components: { App },
    el: '#app',
    icons: {
        iconfont: ['md', 'mdi', 'fa']
       // iconfont: [ 'mdi']
    },

});

