require('./bootstrap');

import Vue from 'vue'
import router from './router'
import store from './store'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
Vue.use(ViewUI);
import common from './common'
import jsonToHtml from './jsonToHtml'
Vue.mixin(common)
Vue.mixin(jsonToHtml)

import Editor from 'vue-editor-js'
// import Editor from '@editorjs/editorjs'
Vue.use(Editor)





Vue.component('mainapp', require('./components/mainapp.vue').default)
const app = new Vue({
    el: '#app',
    router,
    store
})