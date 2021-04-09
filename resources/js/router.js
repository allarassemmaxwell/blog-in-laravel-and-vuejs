import Vue from 'vue'
import Router from 'vue-router'
import firstPage from './components/pages/myFirstVuePage.vue'
import newRoute from './components/pages/newRoutePage.vue'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'

// ADMIN PORJECT PAGES
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import usecom from './vuex/usecom'
import adminuser from './admin/pages/adminusers'
import login from './admin/pages/login'
import role from './admin/pages/role'
import assignRole from './admin/pages/assignRole'
import createBlog from './admin/pages/createBlog'

Vue.use(Router)
const routes = [
    {
        path: '/testvuex',
        component: usecom
    },
    {
        path: '/',
        component: home,
        name: 'home'
    },
    {
        path: '/tags',
        component: tags,
        name: 'tags'
    },
    {
        path: '/category',
        component: category,
        name: 'category'
    },
    {
        path: '/createBlog',
        component: createBlog,
        name: 'createBlog'
    },
    {
        path: '/adminusers',
        component: adminuser,
        name: 'adminusers'
    },
    {
        path: '/login',
        component: login,
        name: 'login'
    },

    {
        path: '/role',
        component: role,
        name: 'role'
    },
    {
        path: '/assignRole',
        component: assignRole,
        name: 'assignRole'
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