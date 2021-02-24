import Vue from 'vue'
import Router from 'vue-router'
import firstPage from './components/pages/myFirstVuePage.vue'
import newRoute from './components/pages/newRoutePage.vue'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

// PORJECT PAGES
import home from './components/pages/home.vue'
import tags from './components/pages/tags.vue'

Vue.use(Router)
const routes = [
    {
        path: '/',
        component: home
    },
    {
        path: '/tags',
        component: tags
    },







    
    // BASIC PROJECT ROUTE
    {
        path: '/my-new-vue-route',
        component: firstPage
    },
    {
        path: '/new-route',
        component: newRoute
    },
    // VUEW HOOKS
    {
        path: '/hooks',
        component: hooks
    },
    // MORE BASICS
    {
        path: '/methods',
        component: methods
    },
]

export default new Router({
    mode: 'history',
    routes
})