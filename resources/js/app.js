require('./bootstrap');
window.Vue = require('vue');

import 'babel-polyfill';
import Vue from 'vue'

/**
 * Import Vue Plugins
 */
//Vuetify v1.x plugin
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'font-awesome/css/font-awesome.min.css'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.css'
Vue.use(Vuetify, {
    theme: store.getters.selectedTheme.theme,
    iconfont: 'md' || 'mdi' || 'fa' || 'fa4'
});

// VueI18n plugin
import VueI18n from 'vue-i18n'
Vue.use(VueI18n)

// Vue breadcrumbs
import VueBreadcrumbs from 'vue2-breadcrumbs'
Vue.use(VueBreadcrumbs)

// Notification plugin
import Notifications from 'vue-notification'
import velocity from 'velocity-animate'
Vue.use(Notifications, {
    velocity
})

// Fullscren plugin
import Fullscreen from 'vue-fullscreen'
Vue.use(Fullscreen)

//Vue offline
import VueOffline from 'vue-offline'
Vue.use(VueOffline)

// Vue clipper
import VuejsClipper from 'vuejs-clipper'
Vue.use(VuejsClipper)

// vue-router
import router from './router'

// vuex
import {
    store
} from './store/store'

// config url
import config from './config'

import globalComponents from './globalComponents'
import primaryTheme from './themes/primaryTheme'
// import './lib/vuelyScript';
// import './lib/vuelyCss';

/* ======= All App File Include Here ======= */
// nprogress
import 'nprogress/nprogress.css'
// leaflet map css
import 'leaflet/dist/leaflet.css'
// Slick Slider
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";
// Icon Files
import './assets/themify-icons/themify-icons.css'
// animate css
import './assets/animate.css';
// Global Scss File
import './assets/scss/_style.scss'


import messages from './lang';
import App from './App.vue'

var access_token = localStorage.getItem('access_token')
axios.defaults.baseURL = config.BASE_URL;
axios.defaults.headers.common['Authorization'] = access_token;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';


Vue.use(require('vue-moment'))
Vue.use(globalComponents);


// create VueI18n instance with options
const i18n = new VueI18n({
    locale: store.getters.selectedLocale.locale,
    messages,
})

/* eslint-disable no-new */
new Vue({
    store,
    i18n,
    router,
    template: '<app></app>',
    components: {
        App
    }
}).$mount('#app')
