require('./bootstrap');
import router from './router'
import store from './store'
import Vue from 'vue'
import ElementUI from 'element-ui'

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    router,
    store
});
